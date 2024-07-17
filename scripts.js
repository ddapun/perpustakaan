$(document).ready(function() {
    $('#addBook').click(function() {
        $('#books').append('<div class="book"><input type="text" name="isbn[]" placeholder="Book ISBN" required><button type="button" class="remove-book">Remove</button></div>');
    });

    $(document).on('click', '.remove-book', function() {
        $(this).parent('.book').remove();
    });
});
