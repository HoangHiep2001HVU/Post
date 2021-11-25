@props(['post' => $post])

<div class="mb-4">
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold">{{$post->user->name}}</a> <span class="text-gray-600
                        text-sm">{{$post->created_at->diffForHumans()}}</span>

    <a href="{{ route('posts.show', $post) }}" class="mb-2">{{$post->body}}</a>

    @can('delete', $post)
    <form action="{{ route('posts.destroy', $post) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-blue-500">Delete</button>
    </form>
    @endcan

    <div class="flex items-center">
        @auth
        @if(!$post->likedBy(auth()->user() ))
        <form action="{{route('posts.likes', $post)}}" method="post" class="mr-1">
            @csrf
            <button type="submit" class="text-blue-500">Like</button>
        </form>
        @else
        <form action="{{route('posts.likes', $post)}}" method="post" class="mr-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Unlike</button>
        </form>
        @endif
        @endauth

        <span>{{$post->likes->count()}} {{Str::plural('like',
                            $post->likes->count())}}</span>
    </div>

    <?php

    use App\Models\Comment;

    $comments = Comment::latest()->where('post_id', '=', $post->id)->paginate(10);
    ?>

    @foreach($comments as $comment)

    <div class="ml-72">
        <a href="{{ route('users.posts', $comment->user) }}" class="font-bold">{{$comment->user->name}}</a> <span class="text-gray-600
                        text-sm">{{$comment->created_at->diffForHumans()}}</span>
        <p>{{$comment->comment}}</p>

        @if($comment->user_id == auth()->user()->id)
        <form action="{{ route('posts.comments', $comment) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Delete</button>
        </form>
        @endif
    </div>

    @endforeach
    {{$comments->links()}}

    @auth
    <form action="{{route('posts.comments', $post)}}" method="post" class="ml-72 ml-1">
        @csrf

        <textarea name="comment" id="comment" cols="30" rows="1" class="bg-gray-100
                    border-2 w-full p-4 rounded-lg @error('comment') border-red-500 @enderror" placeholder="Comment something!"></textarea>
        <button type="submit" class="text-blue-500">Comment</button>
    </form>
    @endauth

</div>