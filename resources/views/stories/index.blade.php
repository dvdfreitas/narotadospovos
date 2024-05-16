Stories

@foreach ($stories as $story)
    <h2>{{ $story->title }}</h2>    
    <h2>{{ $story->subtitle }}</h2>    
@endforeach
