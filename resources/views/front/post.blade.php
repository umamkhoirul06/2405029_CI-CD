<x-blog-layout title="{{ $post_title }}">

    <section class="w-full space-y-8">

        {{-- Main Post Article --}}
        <article class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300">

            {{-- Featured Image --}}
            @if ($post->image)
                <div class="relative h-96 md:h-[500px] overflow-hidden bg-gradient-to-br from-slate-200 to-slate-300">
                    <img src="{{ $post->image }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                         loading="lazy"
                         width="1000" 
                         height="500">
                </div>
            @endif

            {{-- Article Content --}}
            <div class="p-8 md:p-12 space-y-6">

                {{-- Category Badge --}}
                <div class="flex items-center space-x-3">
                    <a href="{{ route('category.show', $post->category->slug) }}"
                        class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider hover:from-indigo-200 hover:to-purple-200 transition-all duration-300">
                        <i class="fas fa-folder mr-2"></i> {{ $post->category->name }}
                    </a>
                </div>

                {{-- Article Title --}}
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">
                    {{ $post->title }}
                </h1>

                {{-- Article Meta --}}
                <div class="flex flex-col md:flex-row md:items-center gap-4 pb-6 border-b border-slate-200">
                    <div class="flex items-center space-x-2 text-slate-600">
                        <i class="fas fa-calendar"></i>
                        <span class="text-sm font-medium">{{ $post->created_at }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-slate-600">
                        <i class="fas fa-clock"></i>
                        <span class="text-sm font-medium">{{ ceil(strlen($post->content) / 200) }} min read</span>
                    </div>
                    <div class="flex items-center space-x-2 text-slate-600">
                        <i class="fas fa-comments"></i>
                        <span class="text-sm font-medium">{{ $post->comments_count }} comments</span>
                    </div>
                </div>

                {{-- Article Body --}}
                <div class="prose max-w-none text-slate-700 leading-relaxed">
                    {!! $post->content !!}
                </div>

                {{-- Tags --}}
                @if ($post->tags_count > 0)
                    <div class="pt-6 border-t border-slate-200">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->name) }}"
                                    class="inline-block px-3 py-2 text-xs font-semibold bg-slate-100 text-slate-700 rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </article>

        {{-- Author Bio Card --}}
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-slate-200 p-8 md:p-10 shadow-md hover:shadow-lg transition-all duration-300">
            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                <img src="{{ $post->user->avatar }}" 
                     alt="{{ $post->user->name }}" 
                     class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-4 border-white shadow-lg">

                <div class="flex-1">
                    <h3 class="text-2xl font-extrabold text-slate-900">{{ $post->user->name }}</h3>
                    <p class="text-slate-600 text-sm mt-1 leading-relaxed">{{ $post->user->bio }}</p>

                    <div class="flex items-center gap-3 text-lg mt-4">
                        @if ($post->user->url_fb)
                            <a href="{{ $post->user->url_fb }}" target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white shadow-md transition-all duration-300 hover:scale-110">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($post->user->url_insta)
                            <a href="{{ $post->user->url_insta }}" target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-pink-600 hover:bg-pink-600 hover:text-white shadow-md transition-all duration-300 hover:scale-110">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($post->user->url_twitter)
                            <a href="{{ $post->user->url_twitter }}" target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-sky-500 hover:bg-sky-500 hover:text-white shadow-md transition-all duration-300 hover:scale-110">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if ($post->user->url_linkedin)
                            <a href="{{ $post->user->url_linkedin }}" target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-700 hover:bg-blue-700 hover:text-white shadow-md transition-all duration-300 hover:scale-110">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Comment Form --}}
        @auth
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8 space-y-6">

                <h3 class="text-2xl font-bold text-slate-900 flex items-center space-x-3">
                    <i class="fas fa-comment text-indigo-600"></i>
                    <span>Add Your Comment</span>
                </h3>

                <form method="POST" action="{{ route('post.comment', $post) }}" class="space-y-4">
                    @csrf

                    <div>
                        <textarea name="body" 
                                  rows="5"
                                  placeholder="Share your thoughts about this post..."
                                  class="w-full border border-slate-300 rounded-xl p-4 text-sm bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-300 resize-none"
                                  required></textarea>
                        @error('body')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Post Comment</span>
                    </button>
                </form>

            </div>
        @else
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 rounded-xl p-8 text-center">
                <i class="fas fa-info-circle text-blue-600 text-3xl mb-3"></i>
                <p class="text-slate-800 font-medium mb-4">Want to join the conversation?</p>
                <p class="text-slate-600 text-sm mb-6">Please <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 underline">sign in</a> or <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 underline">create an account</a> to comment.</p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-slate-200 text-slate-800 rounded-lg font-semibold hover:bg-slate-300 transition">Sign Up</a>
                </div>
            </div>
        @endauth

        {{-- Comments Section --}}
        @if ($post->comments_count > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center space-x-3">
                    <i class="fas fa-comments text-indigo-600"></i>
                    <span>{{ $post->comments_count }} Comments</span>
                </h3>

                <div class="space-y-6">
                    @foreach ($post->comments as $comment)
                        <div class="pb-6 border-b border-slate-200 last:border-0">
                            <div class="flex gap-4">
                                <img src="{{ $comment->user->avatar }}" 
                                     alt="{{ $comment->user->name }}" 
                                     class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-slate-900">{{ $comment->user->name }}</h4>
                                        <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-700 mt-2">{{ $comment->body }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </section>

</x-blog-layout>

            <h3 class="text-xl font-semibold mb-4">Comments</h3>

            @forelse ($post->comments as $comment)
                <div class="border-b last:border-0 py-4">

                    <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
                    <p class="text-sm text-gray-700">{{ $comment->body }}</p>

                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>

                        @can('delete', $comment)
                            <form method="POST" action="{{ route('comment.destroy', $comment->id) }}"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 text-xs hover:underline">Delete</button>
                            </form>
                        @endcan
                    </div>

                </div>
            @empty
                <p class="text-gray-500 text-sm">No comments yet.</p>
            @endforelse

        </div>

        {{-- Prev / Next --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Prev --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-5">
                @if ($post->previous)
                    <p class="text-xs font-semibold text-gray-500 mb-1"><i class="fas fa-arrow-left mr-1"></i> Previous
                    </p>
                    <a href="{{ route('post.show', $post->previous->slug) }}"
                        class="text-gray-900 font-medium hover:text-indigo-600">
                        {{ $post->previous->title }}
                    </a>
                @else
                    <p class="text-gray-400 text-sm">This is the first post.</p>
                @endif
            </div>

            {{-- Next --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-5 text-right">
                @if ($post->next)
                    <p class="text-xs font-semibold text-gray-500 mb-1">Next <i class="fas fa-arrow-right ml-1"></i></p>
                    <a href="{{ route('post.show', $post->next->slug) }}"
                        class="text-gray-900 font-medium hover:text-indigo-600">
                        {{ $post->next->title }}
                    </a>
                @else
                    <p class="text-gray-400 text-sm">This is the last post.</p>
                @endif
            </div>

        </div>

    </section>

</x-blog-layout>
