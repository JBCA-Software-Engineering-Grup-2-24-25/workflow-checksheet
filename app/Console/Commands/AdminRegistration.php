<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Registration for Admin User.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->checkAdminUser()) {
            $this->error('Admin user already exist.');
            return;
        }

        do {
            $userRequest = $this->validateUser($this->user());
        } while ($userRequest === 0);

        DB::transaction(function() use ($userRequest) {
            $userRequest['password'] = bcrypt($userRequest['password']);

            $role = Role::query()->where('name', '=', 'Super Admin')->first();
            // check the superadmin role
            if ($role) {
                $userRequest['role_id'] = $role->id;
            } else { // create new superadmin role if not exist
                $role = Role::query()->create([
                    'name' => 'Super Admin',
                    'author_id' => 1,
                ]);
                $userRequest['role_id'] = $role->id;
            }
            $userRequest['author_id'] = null;
            $userRequest['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
            User::query()->create($userRequest);
            $this->info('Admin Registration Success');
        });
    }

    public function checkAdminUser()
    {
        $admin = User::query()->with(['roleUser' => function($query) {
            $query->where('name', '=', 'Super Admin');
        }])->get();

        if ($admin->count() < 1) {
            return false;
        }

        return true;
    }

    public function user()
    {
        do {
            $name = $this->ask('Input your Full Name');

            // name validation
            $validator = Validator::make(['name' => $name], [
                'name' => 'required', 'string', 'max:255'
            ]);

            if ($validator->fails()) {
                $this->error($validator->errors()->first());
                continue;
            }
        } while ($validator->fails());

        do {
            $email = $this->ask('Input your Email');

            // email validation
            $validator = Validator::make(['email' => $email], [
                'email' => ['required', Rule::unique('users')->whereNull('deleted_at'), 'lowercase', 'email'],
            ]);

            if ($validator->fails()) {
                $this->error($validator->errors()->first());
                continue;
            }
        } while ($validator->fails());

        do {
            $password = $this->secret('Input your Password');
            $password_confirmation = $this->secret('Please Re Input your Password');

            // Validasi password
            $passwordValidator = Validator::make(['password' => $password], [
                'password' => Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]);

            if ($passwordValidator->fails()) {
                $this->error($passwordValidator->errors()->first());
                continue;
            }

            if ($password !== $password_confirmation) {
                $this->error('Passwords do not match. Please try again.');
            }

        } while ($password !== $password_confirmation || $passwordValidator->fails());

        return [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
        ];
    }

    public function validateUser(array $array)
    {
        $validator = Validator::make($array, $this->rulesUser());
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 0;
        }
        $this->info('User Validation Success');
        return $array;
    }

    public function rulesUser()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                Rule::unique('users')->whereNull('deleted_at'),
                'lowercase',
                'email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ];
    }
}
