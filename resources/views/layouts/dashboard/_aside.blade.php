<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-th"><span> @lang('site.dashboard')</span></i></a></li>
            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-th"><span> @lang('site.users')</span></i></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

