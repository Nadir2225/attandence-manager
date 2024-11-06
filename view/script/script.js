// toggle sidebar
const menuBar = document.querySelector('nav .menu');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');

if (window.innerWidth <= 600) {
	sidebar.classList.toggle('hide');
}
menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

//popover
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

// delete multiple users
const checkboxs = document.getElementsByClassName('checkbox');
const selectAllG = document.getElementById('selectAllG');
const selectAllF = document.getElementById('selectAllF');
const selectAllFi = document.getElementById('selectAllFi');
const selectAllGrp = document.getElementById('selectAllGrp');
const deleteBtnG = document.getElementById('deleteBtnG');
const deleteBtnF = document.getElementById('deleteBtnF');
const deleteBtnFi = document.getElementById('deleteBtnFi');
const deleteBtnGrp = document.getElementById('deleteBtnGrp');

let checked = []

const sousFun = (id, role) => {
	user = document.getElementById(id);
	if (user.checked && checked.indexOf(id) == -1) {
		checked.push(id);
	} else  if (!user.checked && checked.indexOf(id) != -1) {
		checked.splice(checked.indexOf(id), 1);
	}
	if (role == 'gest') {
		checked.length != 0 ? deleteBtnG.removeAttribute("disabled") : deleteBtnG.setAttribute("disabled", true)
	} else if (role == 'form') {
		checked.length != 0 ? deleteBtnF.removeAttribute("disabled") : deleteBtnF.setAttribute("disabled", true)
	} else if (role == 'fill') {
		checked.length != 0 ? deleteBtnFi.removeAttribute("disabled") : deleteBtnFi.setAttribute("disabled", true)
	} else if (role == 'grp') {
		checked.length != 0 ? deleteBtnGrp.removeAttribute("disabled") : deleteBtnGrp.setAttribute("disabled", true)
	}
}
const checkedUpdate = (id, role) => {
	sousFun(id, role)
	if (role == 'gest') {
		selectAllG.checked = checked.length != checkboxs.length ? false : true
	} else if (role == 'form') {
		selectAllF.checked = checked.length != checkboxs.length ? false : true
	} else if (role == 'fill') {
		selectAllFi.checked = checked.length != checkboxs.length ? false : true
	} else if (role == 'grp') {
		selectAllGrp.checked = checked.length != checkboxs.length ? false : true
	}
}

selectAllG?.addEventListener('click', event => {
	for (i = 0; i < checkboxs.length; i++) {
		if (event.target.checked) {
			checkboxs[i].checked = true;
			sousFun(checkboxs[i].id, 'gest');
		} else {
			checkboxs[i].checked = false;
			sousFun(checkboxs[i].id, 'gest');
		}
	}
})

selectAllF?.addEventListener('click', event => {
	for (i = 0; i < checkboxs.length; i++) {
		if (event.target.checked) {
			checkboxs[i].checked = true;
			sousFun(checkboxs[i].id, 'form');
		} else {
			checkboxs[i].checked = false;
			sousFun(checkboxs[i].id, 'form');
		}
	}
})

selectAllFi?.addEventListener('click', event => {
	for (i = 0; i < checkboxs.length; i++) {
		if (event.target.checked) {
			checkboxs[i].checked = true;
			sousFun(checkboxs[i].id, 'fill');
		} else {
			checkboxs[i].checked = false;
			sousFun(checkboxs[i].id, 'fill');
		}
	}
})

selectAllGrp?.addEventListener('click', event => {
	for (i = 0; i < checkboxs.length; i++) {
		if (event.target.checked) {
			checkboxs[i].checked = true;
			sousFun(checkboxs[i].id, 'grp');
		} else {
			checkboxs[i].checked = false;
			sousFun(checkboxs[i].id, 'grp');
		}
	}
})

const delBtnFun = (role) => {
	if (confirm('are u sure?')) {
		delForm = document.createElement('form');
		if (role == 'fill') {
			delForm.action = '../../models/filliere/delete.php';
		} else if (role == 'grp') {
			delForm.action = '../../models/groupe/delete.php';
		} else {
			delForm.action = '../../models/user/delete.php';
		}
		delForm.id = 'delForm'
		delForm.method = 'post';
		delForm.style.display = 'none'
		inp = document.createElement('input');
		inp.type = 'text';
		if (role != 'fill' && role != 'grp') {
			inp.name = 'role';
			inp.value = role
		}
		delForm.appendChild(inp)
		checked.forEach(u => {
			inp = document.createElement('input');
			inp.type = 'text';
			inp.name = 'ids[]';
			inp.value = u
			delForm.appendChild(inp)
		});
		document.body.appendChild(delForm)
		// document.getElementById('delForm').submit()
		delForm.submit()
	}
}

deleteBtnG?.addEventListener('click', delBtnFun.bind(this, 'gest'))
deleteBtnF?.addEventListener('click', delBtnFun.bind(this, 'form'))
deleteBtnFi?.addEventListener('click', delBtnFun.bind(this, 'fill'))
deleteBtnGrp?.addEventListener('click', delBtnFun.bind(this, 'grp'))

// stagiaires deletion
const groupBlock = document.getElementById('groupBlock')
const selectGroup = document.getElementById('selectGroup')

const changeDType = e => {
	groupBlock.style.display = e.target.value == 'all' ? 'none' : 'flex'
	e.target.value == 'all' ? selectGroup.removeAttribute("required") : selectGroup.setAttribute("required", true)
}

// emploi toggle

const handleToggle = (inp) => {
	let session = inp.parentNode.parentNode
	session.classList.toggle('unlocked')
}

// toggle type of the absences list weekly/daily
let dayss = document.getElementById('dayss')
let weekly = document.getElementById('weekly')
const toggleType = () => weekly.checked ? dayss.setAttribute('disabled', 'disabled') : dayss.removeAttribute('disabled')

const mysec = document.getElementById('nonluContent')
const onloadFun = () => {
	attendances.forEach(a => {
		grpName = '';
		for (i = 0; i < groups.length; i++) {
			if (groups[i].id == a.groupe) {
				grpName = groups[i].titre;
				break;
			}
		}
		mysec.innerHTML += `
		<div class="att-cont py-2 px-3 d-flex flex-column mb-2">
			<div class="d-flex justify-content-between align-items-center">
				<div class="d-flex align-items-center gap-3">
					<div class="att-group-name">${grpName}</div>
					<div class="text-secondary att-date">${getDateString(a.day, a.week, a.year)}</div>
					<div class="text-secondary att-date">${a.seance == 's1' ? '(8:30 - 11:00)' : a.seance == 's2' ? '(11:00 - 13:30)' : a.seance == 's3' ? '(13:30 - 16:00)' : '(16:00 - 18:30)'}</div>
				</div>
				<div class="btn btn-primary rounded-5" data-bs-toggle="collapse" href="#${a.id}" role="button" aria-expanded="false" aria-controls="collapseExample">Feuille d'absences</div>
			</div>
			<div class="collapse" id="${a.id}"></div>
		</div>
		`;
		displayDataToUpdate(a.id, a.groupe, a.form)
	})
	get = []
	if (document.location.toString().indexOf('?') != -1) {
		get = document.location.toString().split('?')[1].split(/(=|&)/);
	}
	getLimit = 10;
	for (i = 0; i < get.length; i++) {
		if (get[i] == 'limit') {
			getLimit = Number(get[i + 2]);
		}
	}
	if (count >= getLimit) {
		newLimit = getLimit + 10
		mysec.innerHTML += `
		<div class="d-flex justify-content-between align-items-center py-2" style="width: 100%">
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
			<a href='?limit=${newLimit}' style="color: gray;">Plus</a>
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
		</div>
		`;
	}
}


const displayDataToUpdate = (id, groupVal, formId) => {
	let ii = document.getElementById(id)
	let groupName = 'group';
	groups.forEach(g => groupName = g.id == groupVal ? g.titre : groupName);
	let profName = 'formateur';
	forms.forEach(f => profName = f.id == formId ? (f.nom + ' ' + f.prenom) : profName);
	ii.innerHTML = `
		<table class="table" >
			<tbody id="tbody${id}">
				<tr>
					<th colspan="2" style="text-align: center">Groupe : ${groupName}</th>
					<th colspan="2" style="text-align: center">Formateur : ${profName}</th>
				</tr>
				<tr>
					<th>nom</th>
					<th>prenom</th>
					<th style="text-align: center">statu</th>
				</tr>
			</tbody>
		</table>`;
	const tb = document.getElementById(`tbody${id}`);
	stagiaires.forEach(s => {
		if (s.groupe == groupVal) {
			pChecked = 'checked';
			aChecked = '';
			bg = '';
			badge = '<span class="badge text-bg-success">Present(e)</span>'
			for (i = 0; i < absences.length; i++) {
				if (absences[i].stagiaire == s.id && absences[i].attendance == id) {
					pChecked = '';
					aChecked = 'checked';
					badge = '<span class="badge text-bg-danger">Absent(e)</span>'
					bg = 'bg-danger-subtle';
					break;
				}
			}
			tb.innerHTML += `
			<tr>
				<td class="${bg}">${s.nom}</td>
				<td class="${bg}">${s.prenom}</td>
				<td class="${bg}" style="text-align: center">
					${badge}
				</td>
			</tr>
			`;
		}
	})
	tb.innerHTML += `<tr>
			<td colspan="4" style="text-align: center">
			<a href="../../models/attendance/update.php?confirmed=true&id=${id}"><div class="btn btn-primary rounded-5">marquer comme lu</div></a>
			</td>
		</tr>`;
}

// get date string
function getDateString(dayName, weekNum, year) {
	let mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    let jours = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];

	var sunday = new Date(year, 0, (1 + (weekNum - 1) * 7));
    while (sunday.getDay() !== 0) {
        sunday.setDate(sunday.getDate() - 1);
    }
	let day = sunday
	switch (dayName) {
		case 'Lundi':
			day.setDate(day.getDate() + 1);
			break;
		case 'Mardi':
			day.setDate(day.getDate() + 2);
			break;
		case 'Mercredi':
			day.setDate(day.getDate() + 3);
			break;
		case 'Jeudi':
			day.setDate(day.getDate() + 4);
			break;
		case 'Vendredi':
			day.setDate(day.getDate() + 5);
			break;
		case 'Samedi':
			day.setDate(day.getDate() + 6);
			break;
	}
	day = jours[day.getDay() - 1] + ', ' + day.getDate() + ' ' + mois[day.getMonth()] + ' ' + year;
	
    return day;
}

const mysec2 = document.getElementById('historyContent')
const onloadFun2 = () => {
	attendances.forEach(a => {
		grpName = '';
		for (i = 0; i < groups.length; i++) {
			if (groups[i].id == a.groupe) {
				grpName = groups[i].titre;
				break;
			}
		}
		mysec2.innerHTML += `
		<div class="att-cont py-2 px-3 d-flex flex-column mb-2">
			<div class="d-flex justify-content-between align-items-center">
				<div class="d-flex align-items-center gap-3">
					<div class="att-group-name">${grpName}</div>
					<div class="text-secondary att-date">${getDateString(a.day, a.week, a.year)}</div>
					<div class="text-secondary att-date">${a.seance == 's1' ? '(8:30 - 11:00)' : a.seance == 's2' ? '(11:00 - 13:30)' : a.seance == 's3' ? '(13:30 - 16:00)' : '(16:00 - 18:30)'}</div>
				</div>
				<div class="btn btn-primary rounded-5" data-bs-toggle="collapse" href="#${a.id}" role="button" aria-expanded="false" aria-controls="collapseExample">Feuille d'absences</div>
			</div>
			<div class="collapse" id="${a.id}"></div>
		</div>
		`;
		displayDataToUpdate2(a.id, a.groupe, a.form)
	})
	get = []
	if (document.location.toString().indexOf('?') != -1) {
		get = document.location.toString().split('?')[1].split(/(=|&)/);
	}
	getLimit = 10;
	getGroup = '';
	getWeek = '';
	getDay = '';
	getOrder = '';
	for (i = 0; i < get.length; i++) {
		if (get[i] == 'limit') {
			getLimit = Number(get[i + 2]);
		}
		if (get[i] == 'group' && get[i + 2] != '&') {
			getGroup = Number(get[i + 2]);
		}
		if (get[i] == 'day' && get[i + 2] != '&') {
			getDay = get[i + 2];
		}
		if (get[i] == 'week') {
			getWeek = get[i + 2];
		}
		if (get[i] == 'order') {
			getOrder = get[i + 2];
		}
		if (get[i] == 'limit') {
			getLimit = get[i + 2];
		}
	}
	if (count >= getLimit) {
		newLimit = getLimit + 10
		mysec2.innerHTML += `
		<div class="d-flex justify-content-between align-items-center py-2" style="width: 100%">
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
			<a href='?group=${getGroup}&week=${getWeek}&day=${getDay}&order=${getOrder}&limit=${newLimit}' style="color: gray;">Plus</a>
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
		</div>
		`;
	}
}


const displayDataToUpdate2 = (id, groupVal, formId) => {
	let ii = document.getElementById(id)
	let groupName = 'group';
	groups.forEach(g => groupName = g.id == groupVal ? g.titre : groupName);
	let profName = 'formateur';
	forms.forEach(f => profName = f.id == formId ? (f.nom + ' ' + f.prenom) : profName);
	ii.innerHTML = `
		<table class="table" >
			<tbody id="tbody${id}">
				<tr>
					<th colspan="2" style="text-align: center">Groupe : ${groupName}</th>
					<th colspan="2" style="text-align: center">Formateur : ${profName}</th>
				</tr>
				<tr>
					<th>nom</th>
					<th>prenom</th>
					<th style="text-align: center">statu</th>
				</tr>
			</tbody>
		</table>`;
	const tb = document.getElementById(`tbody${id}`);
	stagiaires.forEach(s => {
		if (s.groupe == groupVal) {
			pChecked = 'checked';
			aChecked = '';
			bg = '';
			badge = '<span class="badge text-bg-success">Present(e)</span>'
			for (i = 0; i < absences.length; i++) {
				if (absences[i].stagiaire == s.id && absences[i].attendance == id) {
					pChecked = '';
					aChecked = 'checked';
					badge = '<span class="badge text-bg-danger">Absent(e)</span>'
					bg = 'bg-danger-subtle';
					break;
				}
			}
			tb.innerHTML += `
			<tr>
				<td class="${bg}">${s.nom}</td>
				<td class="${bg}">${s.prenom}</td>
				<td class="${bg}" style="text-align: center">
					${badge}
				</td>
			</tr>
			`;
		}
	})
	tb.innerHTML += `<tr>
			<td colspan="2" style="text-align: end">
			<a href="updateController.php?id=${id}"><div class="btn btn-primary rounded-5">Modifier</div></a>
			</td>
			<td colspan="2" style="text-align: start">
			<a href="../../models/attendance/delete.php?deleteAtd=${id}" onclick="return confirm('vous etes sure de supprimer cette feuille de presence')" ><div class="btn btn-danger rounded-5">Supprimer</div></a>
			</td>
		</tr>`;
}


const tab = document.getElementById('cont')
let sts = '';
const onloadFun3 = () => {
	let groupName = 'group';
	groups.forEach(g => groupName = g.id == attendance.groupe ? g.titre : groupName);
	let profName = 'formateur';
	forms.forEach(f => profName = f.id == attendance.form ? (f.nom + ' ' + f.prenom) : profName);
	tab.innerHTML = `
		<form action="../../models/attendance/update.php" method="post" style="width: 100%;" id="form">
			<table class="table" >
				<tbody id="tbodycont">
					<tr>
						<th colspan="2" style="text-align: center">Groupe : ${groupName}</th>
						<th colspan="2" style="text-align: center">Formateur : ${profName}</th>
					</tr>
					<tr>
						<th style="width: 70px;text-align: center;"><span class="text-success">P</span> <span class="text-danger">A</span></th>
						<th>nom</th>
						<th>prenom</th>
						<th style="text-align: center">statu</th>
					</tr>
				</tbody>
				<tr>
					<td colspan="4" style="text-align: center">
						<input type="submit" name="updateAtd" class="btn btn-primary rounded-5" value="Comfirmer" onclick="handleSubmit(event)">
					</td>
				</tr>
			</table>
		</form>`;
	const tb = document.getElementById(`tbodycont`);
	
	stagiaires.forEach(s => {
		if (s.groupe == attendance.groupe) {
			pChecked = 'checked';
			aChecked = '';
			badge = '<span class="badge text-bg-success">Present(e)</span>'
			for (i = 0; i < absences.length; i++) {
				if (absences[i].stagiaire == s.id && absences[i].attendance == attendance.id) {
					pChecked = '';
					aChecked = 'checked';
					badge = '<span class="badge text-bg-danger">Absent(e)</span>'
					break;
				}
			}
			tb.innerHTML += `
			<tr>
				<td style="text-align: center">
					<input type="radio" name="${s.id}" id="${s.id}p" value="p" onchange="toggleattendance(event)" ${pChecked}>
					<input type="radio" name="${s.id}" id="${s.id}a" value="a" onchange="toggleattendance(event)" ${aChecked}>
				</td>
				<td>${s.nom}</td>
				<td>${s.prenom}</td>
				<td style="text-align: center">
					${badge}
				</td>
			</tr>
			`;
			sts += sts == '' ? s.id : `-${s.id}`;
			tb.innerHTML += `
					<input type="hidden" name="stagiaires" value="${sts}">
					<input type="hidden" name="id" value="${attendance.id}">
					
		`;
		}
	})
}

const handleSubmit = (e) => {
	e.preventDefault();
	ready = true;
	stsArray = sts.split('-');
	stsArray.forEach(st => ready = (!document.getElementById(`${st}p`).checked && !document.getElementById(`${st}a`).checked) ? false : ready);
	if (ready) {
		document.getElementById('form').submit();
	} else {
		alert('veuillez marker tout les stagiaires');
	}
}

// toggle attendance badge
const toggleattendance = (e) => {
	if (e.target.value == 'p') {
		e.target.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '<span class="badge text-bg-success">Present(e)</span>';
	} else {
		e.target.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '<span class="badge text-bg-danger">Absent(e)</span>';
	}
}