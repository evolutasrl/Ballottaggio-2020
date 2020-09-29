<div class="mb-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
           for="nome">
        {{$label}}
    </label>
    <input
        class="appearance-none block w-full bg-gray-200 text-gray-700 rounded  px-4  leading-tight py-3 focus:outline-none focus:bg-white border
    @if(count($errors->get($name)) > 0)border-red-500 bg-red-100 @endif"
        id="nome" type="text" name="{{$name}}"
        @if(old($name))
        value="{{old($name)}}"
        @elseif (isset($values) && $values->$name)
        value="{{ $values->$name}}"
        @endif
    >
    <ul>
        @foreach($errors->get($name) as $error)
            <li class="mt-1 bg-red-500 text-white text-xs rounded p-2 ">{{$error}}</li>
        @endforeach
    </ul>
</div>

