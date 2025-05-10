@props([
    'searchUrl' => '',
    'placeholder' => null,
    'defaultValue' => null,
    'multiple' => false,
    'initialData' => [],
    'classes' => ''
])

<div x-data="selectAxios('{{ $searchUrl }}', '{{ $placeholder ?? '' }}', @js($defaultValue), @js($multiple), @js($initialData))" class="relative {{ $classes }}">
    @if ($multiple)
        <template x-if="content.length > 0">
            <template x-for="item in content">
                <input {{ $attributes }} type="hidden" :value="item">
            </template>
            <span x-text="content.length"></span>
        </template>
    @else
        <input x-ref="inputChoices" {{ $attributes }} type="hidden" x-model="content">
    @endif
    <select x-ref="selectAxios" {{ $multiple ? 'multiple' : '' }}>
    </select>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('selectAxios', (searchUrl, placeholder, defaultValue, multiple, initialData) => ({
                searchUrl: window.location.origin + searchUrl,
                placeholder: placeholder,
                content: multiple ? collect(defaultValue).pluck('value').toArray() : defaultValue.value,
                multiple: multiple,
                data: initialData,
                choices: null,
                search: '',
                init() {
                    this.choices = new Choices(this.$refs.selectAxios, {
                        allowHTML: true,
                        placeholder: true,
                        duplicateItemsAllowed: false,
                        removeItemButton: this.multiple,
                        placeholderValue: this.placeholder,
                        searchPlaceholderValue: this.placeholder,
                        callbackOnInit: function() {
                            this.input.element.name = ''
                        },
                        itemSelectText: '',
                    });

                    // Save choices instance
                    if (Alpine.store('choicesStore')) {
                        Alpine.store('choicesStore').choicesInstance = this.choices;
                        Alpine.store('choicesStore').dataInstance = this.data;
                    }

                    if (typeof defaultValue === 'object') {

                        this.data = collect([defaultValue]).merge(this.data).unique('value').toArray();
                        this.choices.setChoices(this.data);
                    }

                    if (this.multiple && defaultValue.length > 0) {
                        this.data = collect(defaultValue).merge(this.data).unique('value').toArray();
                        this.choices.setChoices(this.data);
                    }

                    this.choices.passedElement.element.addEventListener('search', debounce(async e => {
                        if (e.detail.value.length < 3) {
                            this.resetData(this.data);
                        }

                            if (this.search != e.detail.value && e.detail.value.length >= 3) {
                                this.search = e.detail.value;
                                const url = new URL(this.searchUrl);
                                url.searchParams.append('search', e.detail.value);
                                const data = await axios.get(url)
                                    .then((response) => {
                                        return response.data.data
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                    });
                                if(JSON.stringify(this.data) !== JSON.stringify(data)){
                                    this.resetData(data);
                                }
                            }
                        }, 500));

                    this.choices.passedElement.element.addEventListener('choice', (e) => {
                        if (this.multiple) {
                            this.content.push(e.detail.value);
                        } else {
                            this.content = e.detail.value;
                            this.$refs.inputChoices.value = this.content;
                            this.$refs.inputChoices.dispatchEvent(new Event('change'));
                        }
                    });

                        if (this.multiple) {
                            this.choices.passedElement.element.addEventListener('removeItem', (e) => {
                                this.content = this.content.filter((value) => value != e.detail.value)
                            })
                        }
                    },
                    resetData(data) {
                        if(JSON.stringify(this.data) !== JSON.stringify(data)){
                            this.choices.clearChoices();
                            this.choices.setChoices(data);
                        }
                    }
                }));
            });
    </script>
@endpush
