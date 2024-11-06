// fill the day select
const selectedDay = document.getElementById('selectedDay');
const week = document.getElementById('week');
const fillDays = () => {
	let dispoDays = [];
	selectedDay.innerHTML = "<option value=''>Choisir le jour</option>";
	if (week.value == '') {
		days.forEach(d => (d.s1 == 1 ||d.s3 == 1 ||d.s2 == 1 ||d.s4 == 1) ? dispoDays.push(d) : '');
	} else {
		let weekn = Number(week.value.slice(week.value.indexOf('W') + 1));
		let year = Number(week.value.slice(0, week.value.indexOf('-')));
		days.forEach(d => {
			if (d.s1 == 1 ||d.s3 == 1 ||d.s2 == 1 ||d.s4 == 1) {
				let s = [d.s1, d.s2, d.s3, d.s4];
				for (i = 0; i < attendances.length; i++) {
					s[0] = (s[0] == 1 && attendances[i].seance == 's1' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == d.name) ? 0 : s[0];
					s[1] = (s[1] == 1 && attendances[i].seance == 's2' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == d.name) ? 0 : s[1];
					s[2] = (s[2] == 1 && attendances[i].seance == 's3' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == d.name) ? 0 : s[2];
					s[3] = (s[3] == 1 && attendances[i].seance == 's4' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == d.name) ? 0 : s[3];
				}
				(s[0] == 1 || s[1] == 1 || s[2] == 1 || s[3] == 1) ? dispoDays.push(d) : '';
			} 
		})
		
	}
	dispoDays.forEach(d => {
		selectedDay.innerHTML += `<option value='${d.id}'>${d.name}</option>`;
	})
	toggleGroup();
}

// fill the seance selecet
const selectedSeance = document.getElementById('selectedSeance')
const fillSeances = () => {
	let day = '';
	days.forEach(d => day = d.id == selectedDay.value ? d : day);
	if (day != '') {
		let s = [day.s1, day.s2, day.s3, day.s4];
		if (week.value != '') {
			let weekn = Number(week.value.slice(week.value.indexOf('W') + 1));
			let year = Number(week.value.slice(0, week.value.indexOf('-')));
			for (i = 0; i < attendances.length; i++) {
				s[0] = (s[0] == 1 && attendances[i].seance == 's1' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == day.name) ? 0 : s[0];
				s[1] = (s[1] == 1 && attendances[i].seance == 's2' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == day.name) ? 0 : s[1];
				s[2] = (s[2] == 1 && attendances[i].seance == 's3' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == day.name) ? 0 : s[2];
				s[3] = (s[3] == 1 && attendances[i].seance == 's4' && attendances[i].form == currentUser.id && attendances[i].year == year && attendances[i].week == weekn && attendances[i].day == day.name) ? 0 : s[3];
			}
		}
		selectedSeance.innerHTML = `<option value=''>Choisir la seance</option>`;
		if (s[0] == 1) {
			selectedSeance.innerHTML += `<option value='s1'>8:30 - 11:00</option>`;
		}
		if (s[1] == 1) {
			selectedSeance.innerHTML += `<option value='s2'>11:00 - 13:30</option>`;
		}
		if (s[2] == 1) {
			selectedSeance.innerHTML += `<option value='s3'>13:30 - 16:00</option>`;
		}
		if (s[3] == 1) {
			selectedSeance.innerHTML += `<option value='s4'>16:00 - 18:30</option>`;
		}
	} else {
		selectedSeance.innerHTML = `<option value=''>Choisir la seance</option>`;
	}
	toggleGroup();
}

// abling or disabling the group select
const selectedGroup = document.getElementById('selectedGroup');
const toggleGroup = () => {
	(selectedSeance.value != '' && week.value != '' && selectedDay.value != '') ? selectedGroup.removeAttribute('disabled') : selectedGroup.setAttribute('disabled', 'disabled');
}

// toggle attendance badge
const toggleattendance = (e) => {
	if (e.target.value == 'p') {
		e.target.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '<span class="badge text-bg-success">Present(e)</span>';
	} else {
		e.target.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '<span class="badge text-bg-danger">Absent(e)</span>';
	}
}

// display the students list after choosing which group
let sts = '';
const section = document.getElementById('list-section');
const displayData = () => {
	let weekn = Number(week.value.slice(week.value.indexOf('W') + 1));
	let year = Number(week.value.slice(0, week.value.indexOf('-')));
	let group = 'group';
	groups.forEach(g => group = g.id == selectedGroup.value ? g.titre : group);
	if (selectedGroup.value != '') {
		section.innerHTML = `
		<form action="../models/attendance/create.php" method="post" style="width: 100%;" id="form">
			<table class="table" >
				<tbody id="tbody">
					<tr>
						<th colspan="4" style="text-align: center">${group}</th>
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
						<input type="submit" name="addAbs" class="btn btn-primary rounded-5" value="Comfirmer" onclick="handleSubmit(event)">
					</td>
				</tr>
			</table>
		</form>`;
		const tb = document.getElementById('tbody');
		stagiaires.forEach(s => {
			if (s.groupe == selectedGroup.value) {
				tb.innerHTML += `
				<tr>
					<td style="text-align: center">
						<input type="radio" name="${s.id}" id="${s.id}p" value="p" onchange="toggleattendance(event)">
						<input type="radio" name="${s.id}" id="${s.id}a" value="a" onchange="toggleattendance(event)">
					</td>
					<td>${s.nom}</td>
					<td>${s.prenom}</td>
					<td style="text-align: center">
						<span class="badge text-bg-secondary">non verifie</span>
					</td>
				</tr>
				`;
				sts += sts == '' ? s.id : `-${s.id}`;
			}
		})
		let dy = '';
		days.forEach (d => dy = d.id == selectedDay.value ? d : dy);
		tb.innerHTML += `
					<input type="hidden" name="stagiaires" value="${sts}">
					<input type="hidden" name="year" value="${year}">
					<input type="hidden" name="week" value="${weekn}">
					<input type="hidden" name="day" value="${dy.name}">
					<input type="hidden" name="seance" value="${selectedSeance.value}">
					<input type="hidden" name="form" value="${currentUser.id}">
					<input type="hidden" name="group" value="${selectedGroup.value}">
					
		`;
	} else {
		section.innerHTML = ``;
	}
}



// handle submitting a attendance sheet
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

// fill groups select
const group = document.getElementById('group');
const fillGroupe = () => {
	let get = [];
	if(document.location.toString().indexOf('?') !== -1) {
		get = document.location.toString().split('?')[1].split(/(=|&)/);
		getGroup = '';
		for (i = 0; i < get.length; i++) {
			if (get[i] == 'group') {
				getGroup = get[i + 2];
				break;
			}
		}
		group.innerHTML = getGroup == 'all' ? '<option value="all" selected>tous</option>' : '<option value="all">tous</option>';
		combos.forEach(c => {
			for (i = 0; i < groups.length; i++) {
				if (c.formateur == currentUser.id && c.groupe == groups[i].id) {
					group.innerHTML += getGroup == groups[i].id ? `<option value="${groups[i].id}" selected>${groups[i].titre}</option>` : `<option value="${groups[i].id}">${groups[i].titre}</option>`;
				}
			}
		})
	} else {
		group.innerHTML = '<option value="all" selected>tous</option>';
		combos.forEach(c => {
			for (i = 0; i < groups.length; i++) {
				if (c.formateur == currentUser.id && c.groupe == groups[i].id) {
					group.innerHTML += `<option value="${groups[i].id}">${groups[i].titre}</option>`;
				}
			}
		})
	}
}
// groups filter onchange
const changeFilter = () => window.location.href = `?group=${group.value}&limit=10`;
// alert(group.value)
// const changeFilter = () => alert(group.value);

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

// alert(getDateString('Samedi', 23, 2024))


// idk
const displayDataToUpdate = (id, groupVal) => {
	let ii = document.getElementById(id)
	let groupName = 'group';
	groups.forEach(g => groupName = g.id == groupVal ? g.titre : groupName);
	ii.innerHTML = `
		<table class="table" >
			<tbody id="tbody${id}">
				<tr>
					<th colspan="4" style="text-align: center">${groupName}</th>
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
			sts += sts == '' ? s.id : `-${s.id}`;
		}
	})
}
// displayDataToUpdate('id')

// onload function
const mysec = document.getElementById('attCont');
const onloadFun = () => {
	fillGroupe()
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
		displayDataToUpdate(a.id, a.groupe)
	})
	get = []
	if (document.location.toString().indexOf('?') != -1) {
		get = document.location.toString().split('?')[1].split(/(=|&)/);
	}
	getGroup = 'all';
	getLimit = 10;
	for (i = 0; i < get.length; i++) {
		if (get[i] == 'group') {
			getGroup = get[i + 2];
		}
		if (get[i] == 'limit') {
			getLimit = Number(get[i + 2]);
		}
	}
	if (count >= getLimit) {
		newLimit = getLimit + 10
		mysec.innerHTML += `
		<div class="d-flex justify-content-between align-items-center py-2" style="width: 100%">
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
			<a href='?group=${getGroup}&limit=${newLimit}' style="color: gray;">Plus</a>
			<div style="width: 48%; background-color: gray; height: .5px;"></div>
		</div>
		`;
	}

}