<h1>API пользователи</h1>
    <p>Для того чтобы начать работать с пользователями, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
    <div class="item">
        <h4>Добавление/редактирование пользователя</h4>
        <div class="text">
            <p><span class="param">URL</span> : api.lbr.ru/?r=us&m=set</p>
            <p>Параметры:
            <ul>
                <li><span class="param">action</span> - действие с передаваемым пользователем. <b>photo</b> - добавление/редактирование фотографии пользователя, во всех остальных случаях добавление/редактирование </li>
                <li><span class="param">data</span> - массив с данными о пользователе. Может быть множественным массивом с несколькими пользователями. <br> Принимаемые параметры о пользователе:</li>
                <li>
                    <ul class="table">
                        <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                        <li><span class="param">login</span> <span class="type">(mixed)</span> <span class="info">Логин. Уникальный. Обязательный.</span> </li>
                        <li><span class="param">email</span> <span class="type">(mixed)</span> <span class="info">E-mail адрес. Уникальный</span> </li>
                        <li><span class="param">gender</span> <span class="type">(boolean)</span> <span class="info">Пол. 0 - женский, 1 - мужской</span> </li>
                        <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Имя</span> </li>
                        <li><span class="param">surname</span> <span class="type">(string)</span> <span class="info">Фамилия</span> </li>
                        <li><span class="param">secondname</span> <span class="type">(string)</span> <span class="info">Отчество</span> </li>
                        <li><span class="param">branch</span> <span class="type">(string)</span> <span class="info">Филиал</span> </li>
                        <li><span class="param">direction</span> <span class="type">(string)</span> <span class="info">Направление/Служба</span> </li>
                        <li><span class="param">department</span> <span class="type">(string)</span> <span class="info">Отдел</span> </li>
                        <li><span class="param">position</span> <span class="type">(string)</span> <span class="info">Должность</span> </li>
                        <li><span class="param">dob</span> <span class="type">(date)</span> <span class="info">Дата рождения. Формат YYYY-MM-DD</span> </li>
                        <li><span class="param">date_hire</span> <span class="type">(date)</span> <span class="info">Дата приема на работу. Формат - YYYY-MM-DD</span> </li>
                        <li><span class="param">phone_in</span> <span class="type">(mixed)</span> <span class="info">Номер внутренний</span> </li>
                        <li><span class="param">phone_mb</span> <span class="type">(mixed)</span> <span class="info">Номер мобильный Беларусь</span> </li>
                        <li><span class="param">phone_mr</span> <span class="type">(mixed)</span> <span class="info">Номер мобильный Россия</span> </li>
                        <li><span class="param">skype</span> <span class="type">(mixed)</span> <span class="info">Логин скайпа</span> </li>
                    </ul>
                </li>
                <li>action = <b>photo</b> - добавление/редактирование фотографии пользователя</li>
            </ul><br>
            <p>Пример добавляет/редактирует двух пользователей:
<pre style='font-size: 11px;'>
    action = 'add'
    data[1][login] = 'first_user_login'
    ...
    data[2][login] = 'second_user_login'
</pre>
            Пример удаляет одного пользователя:
<pre style='font-size: 11px;'>
    action = 'del'
    data[login] = 'first_user_login'
</pre>
           </p>
            </p>
        </div>       
    </div>
    <div class="item">
        <h4>Удаление пользователя</h4>
        <div class="text">
            <p><b>URL:</b> /?r=us&m=del</p>
            <p>Параметры:
            <ul>
                <li><span class="param">login</span> <span class="type">(mixed)</span> <span class="info">Логин пользователя в системе учета. Уникальный. Обязательный</span> </li>
            </ul>
<p>Пример удаляет двух пользователей:
<pre style='font-size: 11px;'>
    data[1][login] = 'first_user_login'
    data[2][login] = 'second_user_login'
</pre>
Пример удаляет одного пользователя:
<pre style='font-size: 11px;'>
    data[login] = 'first_user_login'
</pre>
</p>
            </p>
        </div>
    </div>