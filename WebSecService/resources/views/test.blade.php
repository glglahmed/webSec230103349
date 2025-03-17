
@php $name='galal'; $books={"php", "java"}; @endphp
{{$name}}
@foreach($books as book)
      {{$book}}
@endforeach