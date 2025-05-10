@props([
    'containerName' => 'board-container',
])
<div class="overflow-x-scroll custom-scrollbar">
    <table class="w-full my-8 text-sm whitespace-nowrap">
        <thead class="text-left border-b border-gray-100">
            <tr>
                {{ $tableHeaders }}
            </tr>
        </thead>
        <tbody class="{{ $containerName }}">
            {{ $tableBody }}
        </tbody>
    </table>
</div>
