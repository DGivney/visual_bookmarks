$(document).ready(function() {

    if($('#bookmarkList').length) {

        /* create and attach events for filters & search */
        var visualBookmarkSearch = visualBookmarkFilter = '';
        function filterBookmark(obj) {

            if ((obj.attr('data-resource').toLowerCase().indexOf(visualBookmarkSearch) != -1
                    || obj.attr('data-description').toLowerCase().indexOf(visualBookmarkSearch) != -1)
                && obj.attr('data-content-type').toLowerCase().indexOf(visualBookmarkFilter) != -1) {

                obj.show();
            } else {
                obj.hide();
            }
        }

        /* build the filter options */
        var memeFilter = $('<select>')
            .on('change', function(e) {
                visualBookmarkFilter = $(this).find('option:selected').val().toLowerCase();
                $('#bookmarkList>a').each(function() {
                    filterBookmark($(this));
                });
            })

        $.each(['All', 'Application', 'Audio', 'Image', 'Message' , 'Model', 'Text', 'Video'], function(key, value) {
            memeFilter
                .append($('<option>', { value : value.toLowerCase() })
                .text(value));
        });

        /* build the filter control */
        $('<div id="filter">')
            .append(memeFilter)
            .appendTo($('#controls .actions'));

        /* build the search control */
        $('<div id="search">')
            .append($('<input type="text" placeholder="Search" />'))
            .keyup(function(e) {
                visualBookmarkSearch = $(this).find('input').val().toLowerCase();
                $('#bookmarkList>a').each(function() {
                    filterBookmark($(this));
                });
            })
            .appendTo($('#controls .actions'));

        /* dropdown menu handler */
        $("body")
            .on('click', function(e) {
                $('#manage ul').slideUp(100);
                $('#manage a').removeClass('selected');
            })
            .find('#manage a').on('click', function(e) {
                if ($('#manage a').hasClass('selected')) {
                    $('#manage ul').slideUp(100);
                    $('#manage a').removeClass('selected');
                } else {
                    $('#manage ul').slideDown(100);
                    $('#manage a').addClass('selected');
                }
                if (!$(this).hasClass('ajax-form')) {
                    e.stopPropagation();
                }
            });

        /* handle imported file */
        $('#import').on('change', function(e) {
            $(this).closest('form').submit();
        });

        /* handle popup forms and the afterAdd, afterEdit & afterDelete ajax logic */
        $('body').on('click', '.ajax-form', function(e) {
            e.preventDefault();
            var obj = $(this).closest('.bookmark');
            $('#dialog').remove();
            $('<div id="dialog">')
                .appendTo('body')
                .attr('title', $(this).attr('title') ? $(this).attr('title') : $(this).attr('data-title'))
                .load($(this).attr('href') ? $(this).attr('href') : $(this).attr('data-url'), function() {

                    /* init the popup */
                    $('#dialog').dialog({
                        open: function(event, ui) {
                            $(this).on('submit', 'form', {scope: this}, function(e) {
                                e.preventDefault();
                                var form = $(e.data.scope).find('form');

                                /* submit the form via ajax */
                                $.post(form.attr('action'), form.serialize())
                                .done(function(data) {
                                    $(e.data.scope).html(data);

                                    /* if successful decide what additional logic to perform then close dialog */
                                    if ($(data).find('.success').length) {

                                        if ($(e.data.scope).find('.ajax.delete').length) {
                                            obj.remove();
                                        } else if ($(e.data.scope).find('.ajax.edit').length) {
                                            $.get(obj.attr('data-refresh-url'), function(data) {
                                                obj.replaceWith(data);
                                            });
                                        } else if ($(e.data.scope).find('.ajax.add').length) {
                                            window.location.reload();
                                        }

                                        /* close the dialog */
                                        $(e.data.scope).dialog('close');
                                    }
                                })
                                .fail(function() {
                                    alert('An error while submitting this form, please try again.');
                                });
                            });

                            $(this).on('click', '.close', {scope: this}, function(e) {
                                $(e.data.scope).dialog('close');
                            });
                        },
                        close: function() {
                            $(this).remove();
                        }
                    });

                })
        });
    }
});
