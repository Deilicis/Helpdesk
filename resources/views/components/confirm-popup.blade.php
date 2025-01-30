<div id="confirmDeletePopup" class="confirm-popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div class="confirm-popup-content" style="background: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h5>Izdzēst lietotāju?</h5>
        <p>{{ $slot }}</p>
        <button type="button" class="btn btn-secondary" onclick="hideConfirmPopup()">Atcelt</button>
        <form id="deleteUserForm" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Izdzēst</button>
        </form>
    </div>
</div>