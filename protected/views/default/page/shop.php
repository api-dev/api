<h1>API магазин</h1>
<p>Для того, чтобы начать работать с магазином, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<div class="api-tr-list">
    <b>Добавление</b>
    <a href="#addproductmaker">Добавление/редактирование производителя запчастей</a>
    <a href="#addequipmentmaker">Добавление/редактирование производителя техники</a>
    <a href="#addcategory">Добавление/редактирование категорий</a>
    <a href="#addmodelline">Добавление/редактирование модельных рядов и моделей</a>
    <!--a href="#addmodelequipment">Добавление/редактирование отношения модельных рядов к производителям техники (какой производитель закреплен за модельным рядом)</a-->
    <a href="#addgroup">Добавление/редактирование группы запчастей</a>
    <a href="#addsp">Добавление/редактирование запчастей</a>
    <!--a href="#addmodelproduct">Добавление/редактирование отношения товаров (запчастей) к модельным рядам (какие запчасти закреплены за модельным рядом)</a-->
    <a href="#addrelatedproduct">Добавление/редактирование сопутствующих товаров</a>
    <a href="#addanalogproduct">Добавление/редактирование товаров-аналогов</a>
    <a href="#adddraft">Добавление/редактирование сборочных чертежей</a>
    <a href="#addfilial">Добавление/редактирование филиалов и зон</a>
    <a href="#addcurrency">Добавление/редактирование валюты</a>
    <a href="#addprice">Добавление/редактирование цен запчастей (по филиалам)</a>
    <b>Удаление</b>
    <a href="#delsp">Удаление запчастей</a>
    <a href="#delgroup">Удаление группы запчастей</a>
    <a href="#delmodelline">Удаление моделей и модельных рядов</a>
    <b>Получение</b>
    <a href="#getsp">Получение данных о запчастях</a>
    <b>Аналитика</b>
    <a href="#getanalitics">Получение всей имеющейся на текущий момент аналитики (контроль уникальности отдачи)</a>
    <a href="#getanaliticsbytime">Получение аналитики за промежуток времени (без контроля уникальности отдачи)</a>
    <a href="#getanaliticsbyevpid">Получение аналитики по EVP_id и link_id (без контроля уникальности отдачи)</a>
    <a href="#getanaliticsbyevpidunique">Получение аналитики по EVP_id и link_id (c контролем уникальности отдачи)</a>
</div>
<div class="item">
    <h4><a name="addproductmaker">Добавление/редактирование производителя запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>productmaker.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=productmaker:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор производителя в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя запчастей</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя запчастей</span> </li>
                    <!--li><span class="param">published</span> <span class="type">(string)</span><span class="info">Публиковать</span></li-->
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна производителя</span></li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Название картинки (как она будет называться на сайте)</span></li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                </ul>
            </li>
        </ul>
    </div>
    <h4><a name="addequipmentmaker">Добавление/редактирование производителя техники</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>equipmentmaker.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=equipmentmaker:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор производителя в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя техники</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя техники</span> </li>
                    <!--li><span class="param">published</span> <span class="type">(string)</span><span class="info">Публиковать</span></li-->
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна производителя</span></li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Название картинки в системе учета 1С</span></li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                </ul>
            </li>
        </ul>
    </div>
    <h4><a name="addcategory">Добавление/редактирование категорий</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>category.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=category:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название категории</span> </li>
                    <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать категорию пользователям (1) или нет (0)</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние категории:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор категории системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название категории</span> </li>
                                <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать категорию пользователям (1) или нет (0)</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние категории ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует категории:</p>
        <pre style='font-size: 11px;'>
            action = 'category'
            data[0][external_id] = '999999999'
            data[0][name] = 'Почвообработка и посев'
            data[0][inner][0][external_id] = '8888888888'
            data[0][inner][0][name] = 'Бороны дисковые'
            data[0][inner][1][external_id] = '7777777777'
            data[0][inner][1][name] = 'Бороны пружинные'
        </pre>
    </div>
    <h4><a name="addmodelline">Добавление/редактирование модельных рядов и моделей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelline.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelline:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название модельного ряда</span> </li>
                    <li><span class="param">category</span> <span class="type">(string)</span> <span class="info">ID категории в 1С, которой принадлежит модельный ряд</span> </li>
                    <li><span class="param">maker</span> <span class="type">(string)</span> <span class="info">ID производителя техники в 1С, которому принадлежит модельный ряд</span> </li>
                    <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать модельный ряд пользователям (1) или нет (0)</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние модели:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название модели</span> </li>
                                <li><span class="param">category</span> <span class="type">(string)</span> <span class="info">ID категории в 1С, которой принадлежит модель</span> </li>
                                <li><span class="param">maker</span> <span class="type">(string)</span> <span class="info">ID производителя техники в 1С, которому принадлежит модель</span> </li>
                                <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать модель пользователям (1) или нет (0)</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние модели ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует модельный ряд и модели:</p>
        <pre style='font-size: 11px;'>
            action = 'modelline'
            data[0][external_id] = '3333333'
            data[0][name] = '2N Сеялки'
            data[0][category_id] = '9999999999'
            data[0][inner][0][external_id] = '111111'
            data[0][inner][0][name] = '2N-2410'
            data[0][inner][0][category_id] = '8888888888'
            data[0][inner][1][external_id] = '222222'
            data[0][inner][1][name] = '2N-3010'
            data[0][inner][1][category_id] = '7777777777'
        </pre>
    </div>
    <!--h4><a name="addmodelequipment">Добавление/редактирование отношения модельных рядов к производителям техники</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelequipment.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelequipment:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">model</span> <span class="type">(string)</span> <span class="info">Идентефикатор модели в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">maker</span> <span class="type">(string)</span> <span class="info">Идентефикатор производителя техники в системе учета 1С. Уникальный. Обязательный</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример:</p>
        <pre style='font-size: 11px;'>
            action = 'modelequipment'
            data[0][model] = '3333333'
            data[0][maker] = '5555'
        </pre>
    </div-->
    <h4><a name="addgroup">Добавление/редактирование группы запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>group.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=group:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует группы:</p>
        <pre style='font-size: 11px;'>
            action = 'group'
            data[0][external_id] = '111111111'
            data[0][name] = 'Метизы'
            data[0][inner][0][external_id] = '2222222222'
            data[0][inner][0][name] = 'Болты'
            data[0][inner][1][external_id] = '3333333333'
            data[0][inner][1][name] = 'Гайки'
        </pre>
    </div>
    <h4><a name="addsp">Добавление/редактирование запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>sparepart.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=sparepart:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название запчасти</span> </li>
                    <li><span class="param">product_group</span> <span class="type">(string)</span> <span class="info">ID группы в 1С, которой принадлежит запчасть</span> </li>
                    <!--li><span class="param">price_id</span> <span class="type">(int)</span> <span class="info">ID группы цен в 1С</span> </li-->
                    <li><span class="param">catalog_number</span> <span class="type">(string)</span> <span class="info">Каталожный номер</span> </li>
                    <li><span class="param">product_maker</span> <span class="type">(string)</span> <span class="info">ID производителя в 1С, которой принадлежит запчасть</span> </li>
                    <li><span class="param">count</span> <span class="type">(string)</span> <span class="info">Количество в наличии</span> </li>
                    <li><span class="param">min_quantity</span> <span class="type">(int)</span> <span class="info">Минимальное количество для заказа</span> </li>
                    <li><span class="param">liquidity</span> <span class="type">(string)</span> <span class="info">Ликвидность (А, В, С)</span> </li>
                    <li><span class="param">weight</span> <span class="type">(string)</span> <span class="info">Вес, кг</span> </li>
                    <li><span class="param">additional_info</span> <span class="type">(string)</span> <span class="info">Дополнительная информация</span> </li>
                    <li><span class="param">problem</span> <span class="type">(string)</span> <span class="info">Проблемный/сверхпроблемный</span> </li>
                    <li><span class="param">units</span> <span class="type">(string)</span> <span class="info">Единицы измерения</span> </li>
                    <li><span class="param">multiplicity</span> <span class="type">(string)</span> <span class="info">Кратность заказа</span> </li>
                    <li><span class="param">material</span> <span class="type">(string)</span> <span class="info">Материал изделия</span> </li>
                    <li><span class="param">size</span> <span class="type">(string)</span> <span class="info">Размер изделия</span> </li>
                    <li><span class="param">date_sale_off</span> <span class="type">(string)</span> <span class="info">Дата снятия с продажи (формат d.m.Y, например 10.07.2014)</span> </li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Имя изображения запчасти (как она будет называться на сайте)</span> </li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Модели, к которым относится запчасть:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">model</span> <span class="type">(string)</span> <span class="info">Идентефикатор модели в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует две запчасти:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[0][external_id] = '1111111111'
            data[0][name] = 'Датчик весовой 375WS'
            data[0][catalog_number] = '375WS'
            data[0][inner][0][model] = '333333'
            data[0][inner][1][model] = '222222'
            ...
            data[1][external_id] = '222222222'
            data[1][name] = 'Индикатор GT-460'
            data[1][catalog_number] = 'GT-460'
            data[1][inner][0][model] = '444444'
            data[1][inner][1][model] = '555555'
        </pre>
    </div>
    <!--h4><a name="addmodelproduct">Добавление/редактирование отношения товаров (запчастей) к модельным рядам</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">model_line</span> <span class="type">(string)</span> <span class="info">Идентефикатор модели в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Запчасти, относящиеся к данному модельному ряду:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два товара (запчасти) в модельный ряд:</p>
        <pre style='font-size: 11px;'>
            action = 'modelproduct'
            data[0][model_line] = '3333333'
            data[0][inner][0][product_id] = '111111'
            data[0][inner][1][product_id] = '222222'
        </pre>
    </div-->
    
    <h4><a name="addrelatedproduct">Добавление/редактирование сопутствующих товаров</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>relatedproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=relatedproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Сопутствующие товары, относящиеся к указанной запчасти:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">related_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два сопутствующих товара:</p>
        <pre style='font-size: 11px;'>
            action = 'relatedproduct'
            data[0][product_id] = '3333333'
            data[0][inner][0][related_id] = '111111'
            data[0][inner][1][related_id] = '222222'
        </pre>
    </div>
    <h4><a name="addanalogproduct">Добавление/редактирование товаров-аналогов</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analogproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=analogproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Сопутствующие товары, относящиеся к указанной запчасти:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">analog_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два аналога:</p>
        <pre style='font-size: 11px;'>
            action = 'analogproduct'
            data[0][product_id] = '3333333'
            data[0][inner][0][analog_id] = '111111'
            data[0][inner][1][analog_id] = '222222'
        </pre>
    </div>
    <h4><a name="getsp">Получение данных о запчастях</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>sparepart.</b></li>
            <li><span class="param">data</span> - массив с идентефикаторами запчастей.</li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл с информацией о двух запчастях
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[1][external_id] = '5555'
            data[2][external_id] = '6666'
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;sparepart external_id=&quot;5555&quot;&gt;
                &lt;name&gt;Болт&lt;/name&gt;
                &lt;product_group&gt;115545&lt;/product_group&gt;
                &lt;catalog_number&gt;388370A1&lt;/catalog_number&gt;
                &lt;count&gt;2&lt;/count&gt;
                &lt;liquidity&gt;A&lt;/liquidity&gt;
                &lt;additional_info&gt;Сопутствующая информация.&lt;/additional_info&gt;
                &lt;published&gt;1&lt;/published&gt;
                &lt;url&gt;http://lbr-market.ru/sparepart/16251-mufta-kontrolya-vyseva-404-068k/&lt;/url&gt;
                &lt;models&gt;
                    &lt;model external_id=&quot;3566&quot;&gt;3566&lt;/model&gt;
                    &lt;model external_id=&quot;3567&quot;&gt;3567&lt;/model&gt;
                &lt;/models&gt;
            &lt;/sparepart&gt;
            &lt;sparepart external_id=&quot;666&quot;&gt;
                &lt;name&gt;Сальник&lt;/name&gt;
                &lt;product_group&gt;115545&lt;/product_group&gt;
                &lt;catalog_number&gt;388370A2&lt;/catalog_number&gt;
                &lt;count&gt;2&lt;/count&gt;
                &lt;liquidity&gt;A&lt;/liquidity&gt;
                &lt;additional_info&gt;Сопутствующая информация.&lt;/additional_info&gt;
                &lt;published&gt;1&lt;/published&gt;
                &lt;url&gt;http://lbr-market.ru/sparepart/16251-mufta-kontrolya-vyseva-404-068k/&lt;/url&gt;
                &lt;models&gt;
                    &lt;model external_id=&quot;3566&quot;&gt;3566&lt;/model&gt;
                    &lt;model external_id=&quot;3567&quot;&gt;3567&lt;/model&gt;
                &lt;/models&gt;
            &lt;/sparepart&gt;
            
            </pre>        
        </code>
    </div>
    <h4><a name="getanalitics">Получение всей имеющейся на текущий момент аналитики (контроль уникальности отдачи)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=get</p>
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
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=get</p>
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
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=get</p>
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
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=get</p>
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
    <h4><a name="adddraft">Добавление/редактирование сборочных чертежей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>draft.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=draft:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор сборочного чертежа в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Наименование сборочного чертежа</span></li>
                    <li><span class="param">image</span> <span class="type">(string)</span> <span class="info">Имя изображения сборочного чертежа (как он будет называться на сайте)</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Запчасти, относящиеся к сборочному чертежу:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                                <li><span class="param">level</span> <span class="type">(string)</span> <span class="info">Номер на чертеже</span> </li>
                                <li><span class="param">count</span> <span class="type">(string)</span> <span class="info">Количество в узле</span> </li>
                                <li><span class="param">note</span> <span class="type">(string)</span> <span class="info">Примечание</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два товара (запчасти) в модельный ряд:</p>
        <pre style='font-size: 11px;'>
            action = 'draft'
            data[0][external_id] = 'MNS-00001088'
            data[0][name] = 'Ботвоудалитель'
            data[0][image] = 'MNS-00001088.jpg'
            data[0][inner][0][product_id] = '111111'
            data[0][inner][0][level] = '1'
            data[0][inner][0][count] = '2'
            data[0][inner][0][note] = 'Примечание'
            data[0][inner][1][product_id] = '222222'
            data[0][inner][1][level] = '2'
            data[0][inner][1][count] = '1'
            data[0][inner][1][note] = 'Примечание'
        </pre>
    </div>
    <h4><a name="addfilial">Добавление/редактирование филиалов и зон</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>filial.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=filial:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название филиала</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Зоны, входящие в филиал:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор зоны системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название зоны</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует категории:</p>
        <pre style='font-size: 11px;'>
            action = 'filial'
            data[0][external_id] = '999999999'
            data[0][name] = 'Барнаул'
            data[0][inner][0][external_id] = '8888888888'
            data[0][inner][0][name] = 'Алтайский край'
            data[0][inner][1][external_id] = '777777777'
            data[0][inner][1][name] = 'Восточно-Казахстанская область'
        </pre>
    </div>
    <h4><a name="addcurrency">Добавление/редактирование валюты</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>currency.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=currency:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор валюты в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название валюты</span> </li>
                    <li><span class="param">iso</span> <span class="type">(string)</span> <span class="info">Сокращение валюты</span> </li>
                    <li><span class="param">symbol</span> <span class="type">(string)</span> <span class="info">Символ валюты</span> </li>
                    <li><span class="param">exchange_rate</span> <span class="type">(string)</span> <span class="info">Курс валюты</span> </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Пример:</div>
        <p>Пример добавляет/редактирует валюту:</p>
        <pre style='font-size: 11px;'>
            action = 'currency'
            data[0][external_id] = '999999999'
            data[0][name] = 'Доллар'
            data[0][iso] = 'USD'
            data[0][symbol] = '$'
            data[0][exchange_rate] = '1.1'
            data[1][external_id] = '888888888'
            data[1][name] = 'Рубль'
            data[1][iso] = 'RUB'
            data[1][symbol] = 'руб.'
        </pre>
    </div>
    <h4><a name="addprice">Добавление/редактирование цен запчастей (по филиалам)</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>price.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=price:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">filial_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор филиала в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор запчасти в системе учета 1С. Уникальный. Обязательный</span> </li>
                     <li><span class="param">currency_code</span> <span class="type">(string)</span> <span class="info">Идентефикатор валюты в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">price</span> <span class="type">(string)</span> <span class="info">Цена</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует категории:</p>
        <pre style='font-size: 11px;'>
            action = 'price'
            data[0][filial_id] = '666666666'
            data[0][product_id] = '777777777'
            data[0][currency_code] = '888888888'
            data[0][price] = '8'
        </pre>
    </div>
    <h4><a name="delsp">Удаление запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=del</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>sparepart.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=sparepart:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">user_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор пользователя в системе учета, удалившего запчасть</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример удаляет две запчасти:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[0][external_id] = '666666666'
            data[0][user_id] = '1'
            data[1][external_id] = '222222222'
            data[1][user_id] = '3'
        </pre>
        <p>Пример удаляет одну запчасть:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[external_id] = '666666666'
            data[user_id] = '2'
        </pre>
    </div>
    <h4><a name="delgroup">Удаление группы запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=del</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>group.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=group:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">user_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор пользователя в системе учета, удалившего группу запчастей</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример удаляет две группы запчастей:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[0][external_id] = '666666666'
            data[0][user_id] = '1'
            data[1][external_id] = '222222222'
            data[1][user_id] = '3'
        </pre>
        <p>Пример удаляет одну группу:</p>
        <pre style='font-size: 11px;'>
            action = 'group'
            data[external_id] = '666666666'
            data[user_id] = '2'
        </pre>
    </div>
    <h4><a name="delmodelline">Удаление моделей и модельных рядов</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=del</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelline.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelline:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">user_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор пользователя в системе учета, удалившего модель/модельный ряд</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример удаляет две модели:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[0][external_id] = '666666666'
            data[0][user_id] = '1'
            data[1][external_id] = '222222222'
            data[1][user_id] = '3'
        </pre>
        <p>Пример удаляет одну модель:</p>
        <pre style='font-size: 11px;'>
            action = 'group'
            data[external_id] = '666666666'
            data[user_id] = '2'
        </pre>
    </div>
</div>