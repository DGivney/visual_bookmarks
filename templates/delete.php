<div class="ajax delete">
    {% include 'elements/notification.php' %}
    {% if bookmark %}
        <form action="{{url('visual_bookmarks_delete', {id: bookmark.id})}}" method="post">
            <p>Are you sure you want to delete this bookmark?</p>
            <p class="meta">{{bookmark.url|escape}}</p>
            <div class="buttons">
                <input type="submit" value="Yes, delete">
                <span class="close">cancel</span>
            </div>
        </form>
    {% endif %}
</div>