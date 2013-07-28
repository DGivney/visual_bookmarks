<div class="ajax add">
    {% include 'elements/notification.php' %}
    {% if bookmark %}
        <form action="{{url('visual_bookmarks_add')}}" method="post">
        {% include 'elements/bookmark_form.php' %}
        </form>
    {% endif %}
</div>