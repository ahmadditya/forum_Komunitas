@extends('layouts.main')
@section('contents')
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-12 p-0">
                <form action="/home">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Cari tulisan..."
                            value={{ request('search') }}>
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Cari</button>
                    </div>
                </form>
                @if ($posts->count())
                    @foreach ($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body h-100">
                                <div class="d-flex align-items-start">
                                    @if ($post->user->profile_image)
                                        <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="Profile Image" class="img-fluid rounded me-2 rounded-circle" width="36" height="36" />
                                    @else
                                        <img src="/img/avatars/blank.png" alt="Default Profile Image" class="img-fluid rounded-circle me-2" width="36" height="36" />
                                    @endif
                                    <div class="flex-grow-1">
                                        <small class="float-end text-navy">{{ $post->created_at->diffForHumans() }}</small>
                                        <strong>
                                            <a class="text-dark" href="/post/{{ $post->id }}">{{ $post->judul }}</a>
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            <a href="/profile/{{ $post->user->username }}">{{ $post->user->name }}</a> -
                                        </small>
                                        <small class="text-muted">{{ $post->created_at->format('d M Y H:i') }} WIB -
                                        </small>
                                        <small><a href="/categories/{{ $post->category->id }}"
                                                class="text-primary">{{ $post->category->name }}</a></small>

                                        <div class="text-muted mt-1 text-justify">
                                            {!! $post->body !!}
                                        </div>

                                        <button class="btn btn-sm btn-primary mt-2 toggle-comment-form" data-target="comment-form-{{ $post->id }}">
                                            <i class="bi bi-chat-dots"></i>
                                            {{ count($post->comments) }} Tanggapan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Komentar -->
                            <div id="comments-{{ $post->id }}" class="mt-3" style="display: none;">
                                @foreach ($post->comments as $comment)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="Profile Image" class="img-fluid rounded me-2 rounded-circle" width="36" height="36" />
                                                <div>
                                                    <strong>{{ $comment->user->name }}</strong>
                                                    <p class="mb-0">{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Form Komentar -->
                            <div id="comment-form-{{ $post->id }}" class="card mb-3 comment-form" style="display: none;">
                                <div class="card-body">
                                    <form action="/post/{{ $post->id }}/comment" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Komentar:</label>
                                            <textarea class="form-control" id="comment" name="body" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center mt-3">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="card mb-2">
                        <div class="card-body h-100">
                            Data Kosong
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        // Tampilkan atau sembunyikan formulir komentar saat tombol "Tanggapan" diklik
        document.querySelectorAll('.toggle-comment-form').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const commentForm = document.getElementById(targetId);
                const commentsSection = document.getElementById(`comments-${targetId.split('-')[2]}`);
                if (commentForm && commentsSection) {
                    if (commentForm.style.display === 'none') {
                        commentForm.style.display = 'block';
                        commentsSection.style.display = 'block';
                    } else {
                        commentForm.style.display = 'none';
                        commentsSection.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection
