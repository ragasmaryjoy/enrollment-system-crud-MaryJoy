document.addEventListener('DOMContentLoaded', () => {
  loadPrograms();
  loadStudents();
  document.getElementById('student-form').addEventListener('submit', handleFormSubmit);
});

async function loadPrograms() {
  const res = await fetch('api/programs/getPrograms.php');
  const data = await res.json();
  const select = document.getElementById('program');
  select.innerHTML = data.data.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
}

async function loadStudents() {
  const res = await fetch('api/students/getStudents.php');
  const data = await res.json();
  const tbody = document.querySelector('#students-table tbody');
  tbody.innerHTML = '';

  data.data.forEach(student => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${student.id}</td>
      <td>${student.name}</td>
      <td>${student.program}</td>
      <td>${student.allowance}</td>
      <td>
        <button onclick='editStudent(${JSON.stringify(student)})'>Edit</button>
        <button onclick='deleteStudent(${student.id})'>Delete</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function editStudent(student) {
  document.getElementById('student-id').value = student.id;
  document.getElementById('name').value = student.name;
  document.getElementById('program').value = student.program_id;
  document.getElementById('allowance').value = student.allowance;
  document.getElementById('form-title').textContent = "Edit Student";
}

async function deleteStudent(id) {
  if (!confirm("Are you sure?")) return;
  const res = await fetch(`api/students/deleteStudent.php?id=${id}`);
  const result = await res.json();
  alert(result.message);
  loadStudents();
}

function resetForm() {
  document.getElementById('student-id').value = '';
  document.getElementById('name').value = '';
  document.getElementById('program').selectedIndex = 0;
  document.getElementById('allowance').value = '';
  document.getElementById('form-title').textContent = "Add Student";
}

async function handleFormSubmit(e) {
  e.preventDefault();
  const id = document.getElementById('student-id').value;
  const name = document.getElementById('name').value;
  const program_id = document.getElementById('program').value;
  const allowance = document.getElementById('allowance').value;

  const payload = { name, program_id, allowance };
  let url = 'api/students/addStudent.php';

  if (id) {
    payload.id = id;
    url = 'api/students/updateStudent.php';
  }

  const res = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });

  const result = await res.json();
  alert(result.message);
  resetForm();
  loadStudents();
}
