const parentElement = document.querySelector('.post-comments');
const numComments = document.querySelector('#num-comments')
const urlParams = new URLSearchParams(window.location.search);
const url = window.location.pathname;
user = getCookie('user');
comments = [];
page = 1;
current = 0;
taskFired = true;
options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
commentReplyId = null;
username = null;

$(document).ready(function () {
    fetchComments((data) => {
        comments = comments.concat(data.results);
        page = data.pager.pages > page ? page + 1 : page;
        current = data.pager.current;

        numComments.innerHTML = data.pager.items + (data.pager.items > 1 ? ' Comments' : ' Comment');
        updateCommentsHtml();
    }, true);

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
            if (!taskFired) {
                fetchComments((data) => {
                    if (data.pager.current > current) {
                        comments = comments.concat(data.results);
                        page = data.pager.pages > page ? page + 1 : page;
                        current = data.pager.current;
                        updateCommentsHtml();
                    }
                }, true);
            }
        }
    });

    document.querySelector('#post-comment').addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        let inputData = formData.get('comment');

        if (inputData && inputData.replace(username, "").length > 0) {
            $.ajax({
                url: "comment-create",
                data: {
                    blog_id: url.split('/').pop(),
                    message: inputData.includes(username) ? inputData.replace(username, "") : inputData,
                    user_id: 1,
                    reply_id: commentReplyId
                },
                type: 'POST',
            }).done(function () {
                e.target.reset();
                page = 1;

                fetchComments((data) => {
                    comments = data.results;
                    page = data.pager.pages > page ? page + 1 : page;
                    current = data.pager.current;

                    numComments.innerHTML = data.pager.items + (data.pager.items > 1 ? ' Comments' : ' Comment');
                    updateCommentsHtml();
                }, true);
            });
        } else {
            toastr.error("Please fill the field!");
        }
    });
});

const replyToComment = function (id) {
    commentReplyId = id;
    let filterdComment = comments.find(comment => comment.id == parseInt(id));
    let input = $($('#post-comment :input')[0]);
    username = '@' + filterdComment.username + ' ';

    input.focus();
    input.val(username);

    input.on('input', function () {
        if (!this.value.includes(username)) {

            this.value = null;
            commentReplyId = null;
            username = null;
            input.off('input');
        }
    });
}

const doLoading = function () {
    parentElement.innerHTML += `
        <div id="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `;
}

const updateCommentsHtml = function () {
    if (comments.length > 0) {
        let result = comments.filter(comments => !comments.reply_id).map(comment => {
            replies = comments.filter(reply => reply.reply_id == comment.id);

            return `<li class="clearfix">
                        <img src="${getCookie('path')}assets/img/avatars/default.png" class="avatar" alt="">
                        <div class="post">
                            <p class="meta">${comment.username} - ${new Date(comment.created_at).toLocaleString('en-US', options)}

                            </p>
                            <p>
                                ${comment.message}
                            </p>
                        </div>
                        ${replies.length > 0 ?
                    replies.map(reply => {
                        return `<ul class="comment-body">
                                          <li class="clearfix">
                                            <img src="${getCookie('path')}assets/img/avatars/default.png" class="avatar" alt="">
                                                <div class="post">
                                                    <p class="meta">${reply.username} - ${new Date(reply.created_at).toLocaleString('en-US', options)}
<!--                                                        <span class="float-right">-->
<!--                                                          <a href="#"><small>Delete</small></a>-->
<!--                                                        </span>-->
                                                    </p>
                                                    <p>
                                                        ${reply.message}
                                                    </p>
                                                </div>
                                          </li>
                                </ul>`
                    })
                    : ''}
            </li>`
        })

        parentElement.innerHTML = `<ul class="comment-body">
            ${result.join('')}
        </ul>`;
    } else {
        parentElement.innerHTML = '<h5 class="text-center p-2">No comments available</h5>';
    }
}

const fetchComments = function (callback = null, loading = null) {
    if (typeof timeoutFetch !== "undefined") {
        clearTimeout(timeoutFetch);
    }

    timeoutFetch = setTimeout(() => {
        $.ajax({
            url: 'comments/' + url.split('/').pop(),
            data: { page: page },
            dataType: "json",
            beforeSend: function (xhr) {
                if (loading) {
                    doLoading();
                }
                taskFired = true;
            },
            success: function (data) {
                if (loading) {
                    if ($("#loading")) {
                        $("#loading").remove();
                    }
                }

                if (callback) {
                    callback(data);
                } else {
                    console.log('Request success');
                }

                taskFired = false;
            }
        });
    }, 100)
}