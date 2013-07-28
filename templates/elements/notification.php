{% if flash %}
    <div class="alert alert-{{flash.state}} {{flash.state}}">
        {{flash.message}}
    </div>
{% endif %}