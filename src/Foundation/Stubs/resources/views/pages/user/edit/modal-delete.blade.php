
<div id="deleteModal" class="ui basic small modal" style="text-align: center;">
    <div class="content">
        <h1>Are you sure?</h1>
        <p>This action cannot be undone.</p>

        @component('components.shared.form.delete', [ 'action' => route('user.destroy', $user) ])
            <div class="ui cancel button">Cancel</div>
            <input class="ui negative button" type="submit" value="Yes, delete my account">
        @endcomponent
    </div>
</div>
