<!-- Иконка сайта -->
<link rel="shortcut icon" href="media/icons/favicon.ico">
<!-- Стили -->
<link rel="stylesheet" href="scss/style.min.css">
<link rel="stylesheet" href="media/icons/all.min.css">
<!-- Скрипты -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
  const editor = document.querySelector('.editor');

  function doRichEditCommand(command) {
    document.execCommand(command, false, null);
  }

  function doRichEditCommandWithArg(command, arg) {
    document.execCommand(command, false, arg);
  }
</script>
