<div class="nameFilter border p-2">
    <div class="text-center border-bottom mb-1">{{ $title }}</div>
    @foreach($filter as $key => $item)
        <div class="form-check">
            <input class="form-check-input"
                   name="{{ $inputName }}[]"
                   type="checkbox"
                   value="{{ isset($custom_id) ? $key : $item }}"
                   id="{{ $inputName }}{{ $key }}"
                    @if(isset($_GET[$inputName]))
                        @if (in_array($item, $_GET[$inputName])) checked
                        @elseif (isset($custom_id))
                           @if (in_array($key, $_GET[$inputName])) checked @endif
                        @endif
                    @endif
            >
            <label class="form-check-label" for="{{ $inputName }}{{ $key }}">
                {{ $item }}
            </label>
        </div>
    @endforeach
</div>
