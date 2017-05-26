
<div id="deleteModal" class="ui basic small modal" style="text-align: center;">
    <div class="content">
        <h1>Are you sure?</h1>
        <p>This actions cannot be undone.</p>

        @component('components.shared.form.delete', [ 'action' => route('team.destroy', $team) ])
            <div class="ui cancel button">Cancel</div>
            <input class="ui negative button" type="submit" value="Yes, delete {{ $team->name }}">
        @endcomponent
    </div>
</div>
