<body>
<div ng-include="'/tmpl?dir=default&f=templates'"></div>
<div class="pPanel">
    <div class="onePanel" position="left">
        <div class="group-button">
            <button class="button save w-50" ng-click="save()">Сохранить</button>
            <button class="button w-50" ng-click="close()">Закрыть</button>
        </div>
        <pWindow
            class="pWindow tools"
            pwtitle="{{params.pwindow.tools.title}}"
            ng-show="print">
            <label ng-repeat="(tkey, tdata) in params.pwindow.tools.data" class="one-tool {{tdata.type}}" ng-class="{'select':activeTool === tkey}">
                <input
                    type="radio" 
                    name="tools"
                    id="tool-{{tdata.title}}" 
                    ng-value="tkey"
                    ng-click="setActiveTool(tkey)"
                    ng-model="activeTool"
                    >
                {{tdata.title}}
            </label>
        </pWindow>
        <div class="group-button">
            <button class="button w-50" ng-click="switch('p');" ng-class="{active:print}">Для печати</button>
            <button class="button w-50 {{style_e}}" ng-click="switch('e');" ng-class="{active:!print}">Для email</button>
        </div>
    </div>
    <div id="center" class="onePanel" position="center">
        <page ng-repeat="(i, page) in kp.json" link="{{i}}" content="page" class="cursor-{{cursorClass}}" ng-show="print"></page>
        <div ng-bind-html="codehtml" ng-show="!print"></div>
    </div>

    <div class="onePanel" position="right" style="overflow: hidden;">
        <pWindow
            class="pWindow"
            pwtitle="{{params.pwindow.itemCSS.title}}"
            ng-show="print">
            <ul class="activeCss">
                <li ng-repeat="(key, prop) in activeCss.style">
                    <label for="prop-{{key}}">{{key}}:</label>
                    <input id="prop-{{key}}" type="text" value="{{prop}}" ng-model="activeCss.style[key]">
                </li>
                <li ng-show="!activeCss.style">Нет стилей. Выберите элемент.</li>
            </ul>
        </pWindow>
        <pWindow
            class="pWindow"
            pwtitle="Основные параметры"
            ng-show="print">
            <div ng-include="activeContentUrl()"></div>
        </pWindow>

        <pWindow
            class="pWindow structure"
            pwtitle="Структура"
            ng-show="print">
            <ul class="tree">
                <treeitem level="1" class="tree-item level-0 type-page" ulink="kp.json[{{$index}}]" content="item" ng-repeat="item in kp.json" parent="kp.json" index="$index"></treeitem>
            </ul>
        </pWindow>

        <pWindow
            class="pWindow"
            pwtitle="{{params.pwindow.pwKpProperty.title}}"
            >
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.id}}:</label>
                <span class="val">{{kp.id}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.name}}:</label>
                <span class="val"><input ng-model="kp.name" name="name" type="text"></span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.status}}:</label>
                <span class="val">
                    <select ng-model="kp.status" ng-options="c.value as c.label for c in params.status"></select>
                </span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_status}}:</label>
                <span class="val"><input ng-model="kp.date_status" ui-date-format="yy-mm-dd" ui-date="dateOptions"></span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_finish}}:</label>
                <span class="val"><input ng-model="kp.date_finish" ui-date-format="yy-mm-dd" ui-date="dateOptions" ></span>
            </div>

            <div class="hr"></div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.u_id_create}}:</label>
                <span class="val">{{kp.u_id_create.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_create}}:</label>
                <span class="val">{{kp.date_create| normalDate}}</span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.u_id_edit}}:</label>
                <span class="val">{{kp.u_id_edit.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_edit}}:</label>
                <span class="val">{{kp.date_edit| normalDate}}</span>
            </div>

            <div class="hr"></div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_id}}:</label>
                <span class="val">{{kp.auditor_id.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_status}}:</label>
                <span class="val">
                    <select ng-model="kp.auditor_status" ng-options="c.value as c.label for c in params.auditor_status"></select>
                </span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_date_status}}:</label>
                <span class="val">{{kp.auditor_date_status| normalDate}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_comment}}:</label>
                <span class="val"><textarea ng-model="kp.auditor_comment"></textarea></span>
            </div>
        </pWindow>
    </div>
</div>