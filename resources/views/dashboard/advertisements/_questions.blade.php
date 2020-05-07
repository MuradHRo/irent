@foreach($questions as $question)
    <div class="field mb-1">
        <label>{{$question->question}}</label>
        @if(!$question->selections->isEmpty())
            <select class="ui dropdown w-100" name="selections[{{$question->id}}]">
                <option value="">{{$question->question}}</option>
                @foreach($question->selections as $selection)
                    <option value="{{$selection->id}}">{{$selection->name}}</option>
                @endforeach
            </select>
        @else
            <input type="text" placeholder="{{$question->question}}" class="form-control" name="texts[{{$question->id}}]">
        @endif
    </div>
@endforeach
<script>
    $('.ui.dropdown').dropdown();
</script>