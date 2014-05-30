<div class="list-but-panel">
    <button ng-click="create()" class="button save">Создать</button>
</div>
<div class="list-kp">
    <div class="sorter">
        <div ng_repeat="row in rowList" class="{{row.val}}">
            <span ng_click="setOrder(row.val)" ng_class="{'asc':(orderProp==row.val && reverse==true), 'desc':(orderProp==row.val && reverse==false)}">{{row.label}}</span>
        </div>
    </div>
    
    <div class="item" ng-repeat="kp in kpList | orderBy:orderProp:reverse">

        <div class="name">
            <a href="#/list/{{kp.id}}">{{kp.name}}</a>
        </div>

        <div class="status">
            <span>{{kp.status| checkmark}}</span>
        </div>

        <div class="date_status">
            <span>{{kp.date_status| normalDate}}</span>
        </div>

        <div class="date-finish">
            <span>{{kp.date_finish| normalDate}}</span>
        </div>
        
        <div class="auditor_status">
            <span>{{kp.auditor_status| checkmark}}</span>
        </div>

        <div class="auditor">
            <div class="user">
                {{kp.auditor_id.surname}}
            </div>
            <div class="date">
                {{kp.auditor_date_status| normalDate}}
            </div>
        </div>

        <div class="create">
            <div class="user">
                {{kp.u_id_create.surname}}
            </div>
            <div class="date">
                {{kp.date_create| normalDate}}
            </div>
        </div>

        <div class="edit">
            <div class="user">
                {{kp.u_id_edit.surname}}
            </div>
            <div class="date">
                {{kp.date_edit| normalDate}}
            </div>
        </div>

        <div class="trash">
            <button class="button trash" title="Удалить" ng-click="trash(kp.id, $index)"></button>
        </div>
    </div>
</div>