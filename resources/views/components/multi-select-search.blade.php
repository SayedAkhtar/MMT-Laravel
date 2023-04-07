<div class="form-group">
    <label>{{ $label }} </label>
    <select class="form-control" id="{{ $name }}" name="{{ $multiple? $name.'[]' : $name }}" multiple="{{ $multiple }}">
        @forelse($selectedOptions as $option)
            <option value="{{ $option->id }}" selected>{{$option->name}}</option>
        @empty
            <option>Select Option</option>
        @endforelse

    </select>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#{{ $name }}').select2({
                    theme: 'bootstrap4',
                    ajax: {
                        url: route('ajaxSearch', {'table': '{{ $table }}'}),
                        dataType: 'json',
                        data: (params) => {
                            return {
                                term: params.term,
                            }
                        },
                        processResults: (data, params) => {
                            let results = [];
                            if (data.data.length > 0) {
                                results = data.data.map(item => {
                                    return {
                                        id: item.id,
                                        text: item.full_name || item.name,
                                    };
                                });
                            } else {
                                console.error(data);
                            }
                            return {
                                results: results,
                            }
                        },
                    },
                });
            });
        </script>
    @endpush
</div>