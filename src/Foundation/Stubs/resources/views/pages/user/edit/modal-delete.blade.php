
<div id="deleteModal" class="ui basic small modal" style="text-align: center;">
    <div class="content">
        <h1>Are you sure?</h1>
        <p>This actions cannot be undone.</p>

        <form class="ui form" method="POST" action="{{ route('user.destroy', $user) }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            
            <div class="ui cancel button">Cancel</div>
            <input class="ui negative button" type="submit" value="Yes, delete my account">
        </form>
    </div>
</div>
