<div class="ajax edit">
    {% include 'elements/notification.php' %}
    {% if bookmark %}
        <form action="{{url('visual_bookmarks_edit', {id: bookmark.id})}}" method="post">
        {% include 'elements/bookmark_form.php' %}
        </form>
    {% endif %}
</div>