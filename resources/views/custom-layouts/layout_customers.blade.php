<div class="row">
    <div class="col-lg-12">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table user-list">
                        <thead>
                        <tr>
                            <th><span>Sn</span></th>
                            <th><span>Name</span></th>
                            <th class="text-center"><span>Phone</span></th>
                            <th><span>Email</span></th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                        <tr class="list" data-id="{{$customer->id}}">
                            <td>{{++$sn}}</td>
                            <td>
                                <img src="https://bootdey.com/img/Content/user_1.jpg" alt="">
                                <a href="#" class="user-link">{{$customer['name']}}</a>
{{--                                <span class="user-subhead">Member</span>--}}
                            </td>

                            <td class="text-center">
                                <span class="label label-default">{{$customer['phone']}}</span>
                            </td>
                            <td>
                                <a href="#">{{$customer['email']}}</a>
                            </td>
                            <td style="width: 20%;">
                                <a href="#" class="table-link text-warning">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                            </span>
                                </a>
                                <a href="#" class="table-link text-info">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                </a>
                                <a href="#" class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


