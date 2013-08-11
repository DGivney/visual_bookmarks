{{style('style')}}
{{ script('filters') }}

<div id="bookmarkList">
    <div class="import-hint">
        {% if messages %}
        <h1>Import completed sucessfully.</h1>
        <p><a href="{{url('visual_bookmarks_index')}}" title="Return to my bookmarks page">Return to my bookmarks page</a></p>
        <p>
            <ul>
            {% for message in messages %}
                <li><span class="label {{message.status|escape}}">{{message.status|escape}}</span>{{message.url|escape}}</li>
            {% endfor %}
            </ul>
        </p>
        {% else %}
        <h1>Import failed.</h1>
        <p>No links could be extracted from your file.</p>
        <p><a href="{{url('visual_bookmarks_index')}}" title="Return to my bookmarks page">Return to my bookmarks page</a></p>
        {% endif %}

    </div>
</div>