<div class="mb-3">
    <h5 class="font-weight-bold">Permissions</h5>
    <small>Set permission for your role.</small>
</div>
@if ($role !== 'User')
    <div class="form-row">
        <div class="mb-3 col-lg-6">
            <div class="form-check">
                <h5 class="font-weight-bold text-primary">Dashboard</h5>
                <x-form.permission-check label="view admin dashboard stats" />
                <x-form.permission-check label="view users registration chart" />
                <x-form.permission-check label="view other stats" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Investment Plans</h5>
                <x-form.permission-check label="create investment plan" />
                <x-form.permission-check label="view investment plan" />
                <x-form.permission-check label="edit investment plan" />
                <x-form.permission-check label="delete investment plan" />
                <x-form.permission-check label="delete users plan" />
                <x-form.permission-check label="view users plan" />
                <x-form.permission-check label="edit users plan" />
                <x-form.permission-check label="see users plan profit history" />
                <x-form.permission-check label="manually add profit" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Manage Users</h5>
                <x-form.permission-check label="create user" />
                <x-form.permission-check label="view users" />
                <x-form.permission-check label="edit user" />
                <x-form.permission-check label="delete user" />
                <x-form.permission-check label="perform bulk actions" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Transactions</h5>
                <x-form.permission-check label="view transactions" />
                <x-form.permission-check label="delete transactions" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Copytrade</h5>
                <x-form.permission-check label="see copytrade menu" />
                <x-form.permission-check label="manage copytrade settings" />
                <x-form.permission-check label="view providers" />
                <x-form.permission-check label="manage subscribers" />
                <x-form.permission-check label="view symbolmaps" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Signal Provider</h5>
                <x-form.permission-check label="see signal menu" />
                <x-form.permission-check label="manage signals" />
                <x-form.permission-check label="manage signal settings" />
                <x-form.permission-check label="manage signal subscribers" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Crm </h5>
                <x-form.permission-check label="view tasks assigned to them" />
                <x-form.permission-check label="add new task" />
                <x-form.permission-check label="edit task" />
                <x-form.permission-check label="mark task as completed" />
                <x-form.permission-check label="delete task" />
                <x-form.permission-check label="send emails" />
            </div>
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Platform Administration</h5>
                <x-form.permission-check label="view platform administration" />
                <x-form.permission-check label="see administrators" />
                <x-form.permission-check label="change admin password" />
                <x-form.permission-check label="delete admin" />
                <x-form.permission-check label="edit admin details" />
                <x-form.permission-check label="block and unblock admin" />
                <x-form.permission-check label="create admin" />
                <x-form.permission-check label="update roles & permissions" />
                <x-form.permission-check label="view activty log" />
                <x-form.permission-check label="view cronjob" />
                <x-form.permission-check label="perform system cleanup" />
                <x-form.permission-check label="clear cache" />
                <x-form.permission-check label="view system info" />
                <x-form.permission-check label="perform system update" />
            </div>

        </div>
        <div class="mb-3 col-lg-6">
            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Manage Deposits</h5>
                <x-form.permission-check label="view deposits" />
                <x-form.permission-check label="process deposits" />
                <x-form.permission-check label="delete deposits" />
                <x-form.permission-check label="manually create deposit" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Manage Withdrawals</h5>
                <x-form.permission-check label="view withdrawals" />
                <x-form.permission-check label="process withdrawals" />
                <x-form.permission-check label="delete withdrawals" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Kyc Applications</h5>
                <x-form.permission-check label="view kyc applications" />
                <x-form.permission-check label="process kyc applications" />
                <x-form.permission-check label="delete kyc applications" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Education(LMS) - formally called membership</h5>
                <x-form.permission-check label="see membership menu" />
                <x-form.permission-check label="manage categories" />
                <x-form.permission-check label="manage courses" />
                <x-form.permission-check label="manage lessons" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Crypto Swap</h5>
                <x-form.permission-check label="see crypto swap menu" />
                <x-form.permission-check label="manage assets" />
                <x-form.permission-check label="manage swap settings" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Settings</h5>
                <x-form.permission-check label="view settings" />
                <x-form.permission-check label="update general settings" />
                <x-form.permission-check label="update email settings" />
                <x-form.permission-check label="update email templates" />
                <x-form.permission-check label="update dashboard appearance" />
                <x-form.permission-check label="update modules settings" />
                <x-form.permission-check label="update preference" />
                <x-form.permission-check label="view payment methods" />
                <x-form.permission-check label="add payment method" />
                <x-form.permission-check label="edit payment method" />
                <x-form.permission-check label="delete payment method" />
                <x-form.permission-check label="update payment preference" />
                <x-form.permission-check label="update coinpayment settings" />
                <x-form.permission-check label="update stripe settings" />
                <x-form.permission-check label="update paypal settings" />
                <x-form.permission-check label="update paystack settings" />
                <x-form.permission-check label="update flutterwave settings" />
                <x-form.permission-check label="update binance settings" />
                <x-form.permission-check label="update coinbase settings" />
                <x-form.permission-check label="update fund transfer settings" />
                <x-form.permission-check label="update ref & other bonuses" />
                <x-form.permission-check label="update website settings" />
                <x-form.permission-check label="update social login settings" />
                <x-form.permission-check label="update communication settings" />
                <x-form.permission-check label="update control center" />
            </div>

            <div class="mt-2 form-check">
                <h5 class="font-weight-bold text-primary">Account Settings</h5>
                <x-form.permission-check label="admin update account settings" />
            </div>
        </div>
    </div>
@endif
