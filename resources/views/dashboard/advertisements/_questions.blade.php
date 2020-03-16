@foreach($questions as $question)
    <div class="form-group">
        <label>{{$question->question}}</label>
        @if(!$question->selections->isEmpty())
            <select class="custom-select" name="selections[{{$question->id}}]">
                <option value="">{{$question->question}}</option>
                @foreach($question->selections as $selection)
                    <option value="{{$selection->id}}">{{$selection->name}}</option>
                @endforeach
            </select>
        @else
            <input type="text" class="form-control" name="texts[{{$question->id}}]">
        @endif
    </div>
@endforeach