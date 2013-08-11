<div class="input text">
    <label>Title</label>
    <input type="text" name="data[Bookmark][title]" value="{{bookmark.title|escape}}">
</div>
<div class="input text">
    <label>Location</label>
    <input type="text" name="data[Bookmark][url]" value="{{bookmark.url|escape}}">
</div>
<div class="input textarea">
    <label>Description</label>
    <textarea name="data[Bookmark][description]">{{bookmark.description|escape}}</textarea>
</div>
<div class="buttons">
    <input type="submit" value="Yes, save">
    <span class="close">cancel</span>
</div>