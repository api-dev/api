<!-- Шаблоны окна основных параметров -->
<script type="text/ng-template" id="block.html" xmlns="http://www.w3.org/1999/html">
    Нет параметров
</script>

<script type="text/ng-template" id="page.html">
    Информация о странице
</script>

<script type="text/ng-template" id="image.html">
    <label for="active-image-url" class="params-label">URL адрес изображения:</label><br>
    <input type="text" ng-model="activeCss.content.src" id="active-image-url" class="params-input">
    <ul class="activeCss">
        <li>
            <label for="active-image-alt">Альт. текст:</label>
            <input type="text" ng-model="activeCss.content.alt" id="active-image-alt">
        </li>
        <li>
            <label for="active-image-title">Заголовок</label>
            <input type="text" ng-model="activeCss.content.title" id="active-image-title">
        </li>
    </ul>
</script>

<script type="text/ng-template" id="string_link.html">
    <label class="params-label">Содержание:</label>
    <textarea ng-model="activeCss.content" class="params-input"></textarea>
    <label for="active-text-href" class="params-label">Cсылка:</label><br>
    <input type="text" ng-model="activeCss.href" id="active-text-href" class="params-input">
</script>

<script type="text/ng-template" id="string.html">
    <label class="params-label">Содержание:</label>
    <textarea ng-model="activeCss.content" class="params-input"></textarea>
</script>

<script type="text/ng-template" id="varible.html">
    <label class="params-label">Переменная:</label>
    <input type="text" ng-model="activeCss.content" class="params-input">
</script>
<!-- Шаблоны окна основных параметров -->