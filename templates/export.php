<!DOCTYPE NETSCAPE-Bookmark-file-1>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!-- This is an automatically generated file.
It will be read and overwritten.
Do Not Edit! -->
<TITLE>Bookmarks</TITLE>
<H1>Bookmarks</H1>
<DL>
{% for bookmark in bookmarks %}
    <DT><A HREF="{{bookmark.url}}" DESCRIPTION="{{bookmark.description|escape}}">{% if bookmark.title %}{{bookmark.title|escape}}{% else %}{{bookmark.domainWithoutExt|escape}}{% endif %}</A></DT>
    {% if bookmark.description %}
    <DD>{{bookmark.description|escape}}</DD>
    {% endif %}
{% endfor %}
</DL>