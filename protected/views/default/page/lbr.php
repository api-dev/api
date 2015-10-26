<div><a href="http://www.lbr.ru/users/login/">Вход на сайт</a></div>
<br/>
<h1>API сайта ЛБР</h1>
<p>Для того, чтобы начать работать с магазином, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<div class="api-tr-list">
    <b>Аналитика</b>
    <a href="#getanalitics">Получение всей имеющейся на текущий момент аналитики (контроль уникальности отдачи)</a>
    <a href="#getanaliticsbytime">Получение аналитики за промежуток времени (без контроля уникальности отдачи)</a>
    <a href="#getanaliticsbyevpid">Получение аналитики по EVP_id и link_id (без контроля уникальности отдачи)</a>
    <a href="#getanaliticsbyevpidunique">Получение аналитики по EVP_id и link_id (c контролем уникальности отдачи)</a>
</div>
<div class="item">
    <h4><a name="getanalitics">Получение всей имеющейся на текущий момент аналитики (контроль уникальности отдачи)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/lbr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analitics.</b></li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл со следующими параметрами:
        <pre style='font-size: 11px;'>
            customer_id - id пользователя (email)
            subscription_id - id рассылки
            link_id - id ссылки
            time - время в секундах
            date - время регистрации захода (формат Y.m.d H:i)
            url_mark - соответствие позиции каталога (category/modelline/maker/pmaker/product)
                       Например: "category=MNN01111" или "category=MNN01111;maker=000111",
                       здесь <b>maker</b> - производитель техники, 
                       <b>pmaker</b> - производитель запчастей, 
                       <b>category</b> - тип техники, 
                       <b>product</b> - запчасть, 
                       <b>modelline</b> - модельный ряд
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;data count=&quot;2&quot;&gt;
                &lt;info id=&quot;2&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru_test2@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;link&lt;/link_id&gt;
                    &lt;time&gt;6.061&lt;/time&gt;
                    &lt;date&gt;2014.10.01 12:11&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru/catalog/traktornaya-tehnika&lt;/url&gt;
                    &lt;url_mark&gt;5555&lt;/url_mark&gt;
                &lt;/info&gt;
                &lt;info id=&quot;666&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;&lt;/link_id&gt;
                    &lt;time&gt;12.671&lt;/time&gt;
                    &lt;date&gt;2015.08.14 16:48&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru&lt;/url&gt;
                    &lt;url_mark&gt;&lt;/url_mark&gt;
                &lt;/info&gt;
            &lt;/data&gt;
            </pre>        
        </code>
    </div>
    <h4><a name="getanaliticsbytime">Получение аналитики за промежуток времени (без контроля уникальности отдачи)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/lbr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analiticsbytime.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=analiticsbytime:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">from</span> <span class="type">(string)</span> <span class="info"> Дата начала промежутка - формат Y-m-d, например 2015-08-01</span></li>
                    <li><span class="param">to</span> <span class="type">(string)</span> <span class="info"> Дата окончания промежутка (включительно) - формат Y-m-d, например 2015-08-02</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл со следующими параметрами:
        <pre style='font-size: 11px;'>
            customer_id - id пользователя (email)
            subscription_id - id рассылки
            link_id - id ссылки
            time - время в секундах
            date - время регистрации захода (формат Y.m.d H:i)
            url_mark - соответствие позиции каталога (category/modelline/maker/pmaker/product)
                       Например: "category=MNN01111" или "category=MNN01111;maker=000111",
                       здесь <b>maker</b> - производитель техники, 
                       <b>pmaker</b> - производитель запчастей, 
                       <b>category</b> - тип техники, 
                       <b>product</b> - запчасть, 
                       <b>modelline</b> - модельный ряд
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;data count=&quot;2&quot;&gt;
                &lt;info id=&quot;2&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru_test2@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;link&lt;/link_id&gt;
                    &lt;time&gt;6.061&lt;/time&gt;
                    &lt;date&gt;2014.10.01 12:11&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru/catalog/traktornaya-tehnika&lt;/url&gt;
                    &lt;url_mark&gt;5555&lt;/url_mark&gt;
                &lt;/info&gt;
                &lt;info id=&quot;666&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;&lt;/link_id&gt;
                    &lt;time&gt;12.671&lt;/time&gt;
                    &lt;date&gt;2015.08.14 16:48&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru&lt;/url&gt;
                    &lt;url_mark&gt;&lt;/url_mark&gt;
                &lt;/info&gt;
            &lt;/data&gt;
            </pre>        
        </code>
    </div>
    <h4><a name="getanaliticsbyevpid">Получение аналитики по EVP_id и link_id (без контроля уникальности отдачи)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/lbr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analiticsbyevpid.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=analiticsbyevpid:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">subscription_id</span> <span class="type">(string)</span> <span class="info">Уникальный идентификатор ЭВП</span></li>
                    <li><span class="param">link_id</span> <span class="type">(string)</span> <span class="info">1 или 0 - учитывать ли id ссылки при выборке</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл со следующими параметрами:
        <pre style='font-size: 11px;'>
            customer_id - id пользователя (email)
            subscription_id - id рассылки
            link_id - id ссылки
            time - время в секундах
            date - время регистрации захода (формат Y.m.d H:i)
            url_mark - соответствие позиции каталога (category/modelline/maker/pmaker/product)
                       Например: "category=MNN01111" или "category=MNN01111;maker=000111",
                       здесь <b>maker</b> - производитель техники, 
                       <b>pmaker</b> - производитель запчастей, 
                       <b>category</b> - тип техники, 
                       <b>product</b> - запчасть, 
                       <b>modelline</b> - модельный ряд
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;data count=&quot;2&quot;&gt;
                &lt;info id=&quot;2&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru_test2@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;link&lt;/link_id&gt;
                    &lt;time&gt;6.061&lt;/time&gt;
                    &lt;date&gt;2014.10.01 12:11&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru/catalog/traktornaya-tehnika&lt;/url&gt;
                    &lt;url_mark&gt;5555&lt;/url_mark&gt;
                &lt;/info&gt;
                &lt;info id=&quot;666&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;&lt;/link_id&gt;
                    &lt;time&gt;12.671&lt;/time&gt;
                    &lt;date&gt;2015.08.14 16:48&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru&lt;/url&gt;
                    &lt;url_mark&gt;&lt;/url_mark&gt;
                &lt;/info&gt;
            &lt;/data&gt;
            </pre>        
        </code>
    </div>
    <h4><a name="getanaliticsbyevpidunique">Получение аналитики по EVP_id и link_id (с контролем уникальности отдачи)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/lbr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analiticsbyevpidunique.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=analiticsbyevpidunique:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">subscription_id</span> <span class="type">(string)</span> <span class="info">Уникальный идентификатор ЭВП</span></li>
                    <li><span class="param">link_id</span> <span class="type">(string)</span> <span class="info">1 или 0 - учитывать ли id ссылки при выборке</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл со следующими параметрами:
        <pre style='font-size: 11px;'>
            customer_id - id пользователя (email)
            subscription_id - id рассылки
            link_id - id ссылки
            time - время в секундах
            date - время регистрации захода (формат Y.m.d H:i)
            url_mark - соответствие позиции каталога (category/modelline/maker/pmaker/product)
                       Например: "category=MNN01111" или "category=MNN01111;maker=000111",
                       здесь <b>maker</b> - производитель техники, 
                       <b>pmaker</b> - производитель запчастей, 
                       <b>category</b> - тип техники, 
                       <b>product</b> - запчасть, 
                       <b>modelline</b> - модельный ряд
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;data count=&quot;2&quot;&gt;
                &lt;info id=&quot;2&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru_test2@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;link&lt;/link_id&gt;
                    &lt;time&gt;6.061&lt;/time&gt;
                    &lt;date&gt;2014.10.01 12:11&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru/catalog/traktornaya-tehnika&lt;/url&gt;
                    &lt;url_mark&gt;5555&lt;/url_mark&gt;
                &lt;/info&gt;
                &lt;info id=&quot;666&quot;&gt;
                    &lt;customer_id&gt;test1@mail.ru&lt;/customer_id&gt;
                    &lt;subscription_id&gt;test_info&lt;/subscription_id&gt;
                    &lt;link_id&gt;&lt;/link_id&gt;
                    &lt;time&gt;12.671&lt;/time&gt;
                    &lt;date&gt;2015.08.14 16:48&lt;/date&gt;
                    &lt;url&gt;http://lbr-market.ru&lt;/url&gt;
                    &lt;url_mark&gt;&lt;/url_mark&gt;
                &lt;/info&gt;
            &lt;/data&gt;
            </pre>        
        </code>
    </div>
</div>

