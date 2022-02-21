<button dusk="addStudent-button" type="button" data-toggle="modal" data-target="#infos-add" id="buttonModalAdd" class="btn btn-outline-success">
  Ajouter étudiant
</button>
<div class="modal" id="infos-add">
  <div class="modal-dialog" id="deleteStudentdialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Ajouter étudiant</h2>
      </div>
      <div class="modal-body">
        <form class="FormModal" method="POST" action="{{ route('addInCourse') }}">
          @csrf
          <div class="form-group">
            <label>Le matricule de l'étudiant :</label>
            <input type="number" id="inputModal" name="studentId">
          </div>
          <br>
          <input type="hidden" name="courseId" value="{{$courseId}}">
          <br>
          <button dusk="add-button" type="submit" id="addButton" class="btn btn-outline-success">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
</div>