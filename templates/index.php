{{style('style')}}
{{ script('filters') }}

<div id="controls">
    <div class="actions">
        <div id="manage" class="button">
            <a href="#">Actions</a>
            <ul>
                <li class="icon-add"><p><a href="{{url('visual_bookmarks_add')}}" class="add ajax-form action-link" title="Add bookmark">Add</a></p></li>
                <li class="icon-upload">
                    <form action="{{url('visual_bookmarks_import')}}" method="post" enctype="multipart/form-data">
                        <input id="import" type="file" size="5" name="import_file">
                    </form>
                    <p class="action-link">Import</p>
                </li>
                <li class="icon-download"><p><a href="{{url('visual_bookmarks_export')}}" class="action-link">Export</a></p></li>
            </ul>
        </div>
    </div>
</div>
<div id="bookmarkList">
    {% if bookmarks %}
        {% for bookmark in bookmarks %}
            {% include 'elements/bookmark.php' %}
        {% endfor %}
    {% else %}
    <div class="bookmark-hint">
        <h1>You don't have any bookmarks yet.</h1>
        <p>You can add bookmarks using the import function.</p>
    </div>
    {% endif %}
</div>