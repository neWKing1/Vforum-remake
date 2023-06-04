@auth
@if(session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="" class="mb-3" id="frm">
    @csrf
    @include('comments.form')
    <button class="btn btn-primary w-100" id="add-comment" type="submit">Add comment</button>
</form>
@else
<div>
    <a href="{{ route('login') }}">Sig-in</a> to post comments!
</div>
@endauth
@push('scripts')
<script>
    $(document).ready(function() {
        // create comment
        $('#frm').submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('comments.store') }}",
                data: $('#frm').serialize(),
                type: 'post',
                success: function(result) {
                    // console.log(typeof(result));
                    console.log(result);
                    const {
                        id,
                        content,
                        time,
                        user: {
                            name
                        }
                    } = result
                    console.log(content, time, name);
                    const html = `
                    <div class="justify-content-between comment__content comment__content--${id} comment__content--active">
                        <div class="">
                            <span>${content}</span>
                            <p class="text-secondary">Added ${time},by ${name}</p>
                        </div>
                        <section>
                            <div class="dropdown">
                                <button class="border-0 bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis fs-4 text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="btn btn-light w-100 btn__comment--edit" data-id="${id}">Edit</button>
                                    </li>
                                    <li>
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')" class="comment__delete-form comment__delete-form--${id}" data-id="${id}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-light w-100">Delete</button>
                                        </form>
                                    </li>
                                    <li>
                                    <button class="btn btn-light w-100">Hide Comment</button>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </div>
                    `
                    $("textarea").val("");
                    if ($('#cmt').find('#no-cmt')) {
                        $('#cmt').find('#no-cmt').remove();
                    }
                    $('#cmt').append(html);

                    // edit comment
                    editComment()
                    // delete comment
                    deleteComment()

                },
            })
        })

        function editComment() {
            const commentContainer = $('.comment__content')
            commentContainer.click(function(e) {
                if (e.target.classList.contains('comment__btn-edit')) {
                    const id = e.target.dataset.id
                    console.log(id);
                    commentContainer.addClass('comment__content--active')
                    const commentContent = $(`.comment__content--${id}`)
                    commentContent.removeClass('comment__content--active')
                    // console.log(commentContent);
                    $.ajax({
                        url: "{{ route('comments.edit') }}",
                        data: {
                            id: id,
                        },
                        type: 'get',
                        success: function(result) {
                            // console.log(result);
                            const {
                                id,
                                content
                            } = result
                            // console.log(content);
                            html = `
                        <form action="" class="comment__edit-form comment__edit-form--${id} comment__edit-form--active w-100 mb-3" method="post">
                            @csrf
                            @method('patch')
                            <input type="number" class="form-control" value="${id}" hidden name="id">
                            <div class="position-relative">
                                <textarea rows="5" cols="" class="form-control w-100" name="content" autofocus>${content}</textarea>
                                <button class="btn btn-primary position-absolute bottom-0 start-100" type="submit"><i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </form>
                        `
                            commentContent.after(html);
                            const commentEditFormContainer = $('.comment__edit-form--active')
                            console.log(commentEditFormContainer.length);
                            if (commentEditFormContainer.length == 2) {
                                commentEditFormContainer.eq(1).remove()
                            }
                            console.log(commentEditFormContainer);
                            commentEditFormContainer.eq(0).submit(function(e) {
                                e.preventDefault();
                                console.log(commentEditFormContainer.eq(0).serialize());
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: "{{ route('comments.update') }}",
                                    data: commentEditFormContainer.eq(0).serialize(),
                                    type: 'patch',
                                    success: function(result) {
                                        console.log(result);
                                        const {
                                            content
                                        } = result
                                        commentEditFormContainer.eq(0).remove()
                                        commentContent.addClass('comment__content--active')
                                        commentContent.find("span").text(content)
                                    }
                                })
                            })
                        }
                    })
                }
            })
        }

        function deleteComment() {
            const commentDeleteFormContainer = $('.comment__delete-form')
            commentDeleteFormContainer.submit(function(e) {
                e.preventDefault()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                console.log(e.target.dataset.id);
                $.ajax({
                    url: "{{ route('comments.destroy') }}",
                    data: {
                        id: e.target.dataset.id,
                        _token: "{{ csrf_token() }}",
                    },
                    type: 'delete',
                    success: function(result) {
                        console.log(result);
                        $(`.comment__content--${e.target.dataset.id}`).remove()
                    },
                })
            })
        }

        editComment()
        deleteComment()
    })
</script>
@endpush