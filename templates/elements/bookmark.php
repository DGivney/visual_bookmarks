{% if bookmark %}
<a class="bookmark" href="{{url('visual_bookmarks_redirect', {id: bookmark.id})}}"
    target="_blank" title="{{bookmark.title|escape}}"
    data-content-type="all|{{bookmark.type|escape}}"
    data-resource="{{bookmark.title|escape}}|{{bookmark.hostname|escape}}"
    data-description="{{bookmark.description|escape}}"
    data-refresh-url="{{url('visual_bookmarks_view', {id: bookmark.id})}}"
    style="background-color: {{bookmark.color}};">

    <span class="tools">
        <span class="delete ajax-form" data-url="{{url('visual_bookmarks_delete', {id: bookmark.id})}}" data-title="Delete bookmark">delete</span>
        <span class="edit ajax-form" data-url="{{url('visual_bookmarks_edit', {id: bookmark.id})}}" data-title="Edit bookmark">edit</span>
    </span>
    <span class="title">
        <h3>{{bookmark.title[:47]|escape}}</h3>
        <span class="meta">{{bookmark.hostname|escape}}</span>
    </span>
</a>
{% endif %}