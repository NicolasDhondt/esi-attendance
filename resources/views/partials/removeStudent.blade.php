<button dusk="deleteStudent-button" type="button" data-toggle="modal" data-target="#infos-delete" id="buttonModalDelete" class="btn btn-outline-danger">
    Supprimer étudiant
</button>
<div class="modal" id="infos-delete">
    <div class="modal-dialog" id="deleteStudentdialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Supprimer étudiant</h2>
            </div>
            <div class="modal-body">
                <form class="FormModal" method="POST" action="{{ route('deleteInCourse') }}">
                    @csrf
                    <div class="form-group">
                        <label>Le matricule de l'étudiant :</label>
                        <input dusk="inputRemoveStudent"type="number" id="inputModal" name="studentId">
                    </div>
                    <br>
                    <input type="hidden" name="courseId" value="{{$courseId}}">
                    <br>
                    <button dusk="delete-button" type="submit" id="deleteButton" class="btn btn-outline-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
