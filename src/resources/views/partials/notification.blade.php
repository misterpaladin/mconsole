<script type="text/javascript">
    $(function () {
        notifications.push('{{ addslashes($type) }}', '{{ isset($text) ? addslashes($text) : null }}', '{{ isset($title) ? addslashes($title) : null }}');
    })
</script>