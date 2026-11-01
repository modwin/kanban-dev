const statuses = ['backlog', 'in_progress', 'code_review', 'testing', 'done'];

async function fetchCards() {
    const res = await fetch('/api/cards');
    if (res.status === 401) {
        window.location.href = '/login';
        return;
    }
    const json = await res.json();
    renderBoard(json.data || []);
}

function renderBoard(cards) {
    statuses.forEach(s => {
        const col = document.querySelector(`.column[data-status="${s}"] .cards-list`);
        col.innerHTML = '';
    });

    cards.forEach(c => {
        const col = document.querySelector(`.column[data-status="${c.status}"] .cards-list`);
        if (!col) return;
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
                    <div class="card-header">
                        <span class="badge badge-${c.issue_type}">${c.issue_type}</span>
                        <span class="badge badge-p">${c.priority} • ${c.story_points} SP</span>
                    </div>
                    <div class="card-title">${c.title}</div>
                    ${c.branch_name ? `<div class="card-meta"><span class="branch-tag">🌿 ${c.branch_name}</span></div>` : ''}
                    <div class="card-actions">
                        <select onchange="updateStatus(${c.id}, this.value)" class="form-control" style="font-size: 0.75rem; padding: 2px;">
                            ${statuses.map(st => `<option value="${st}" ${st === c.status ? 'selected' : ''}>${st.replace('_', ' ')}</option>`).join('')}
                        </select>
                        <button onclick="deleteCard(${c.id})" class="btn btn-danger" style="font-size: 0.7rem; padding: 2px 6px;">✕</button>
                    </div>
                `;
        col.appendChild(card);
    });
}

async function updateStatus(id, status) {
    await fetch(`/api/cards/${id}/status`, {
        method: 'PATCH',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({status})
    });
    fetchCards();
}

async function deleteCard(id) {
    if (!confirm('Delete this task?')) return;
    await fetch(`/api/cards/${id}`, {method: 'DELETE'});
    fetchCards();
}

async function submitCard() {
    const payload = {
        title: document.getElementById('card-title').value,
        description: document.getElementById('card-desc').value,
        issue_type: document.getElementById('card-type').value,
        priority: document.getElementById('card-priority').value,
        story_points: parseInt(document.getElementById('card-sp').value, 10),
        branch_name: document.getElementById('card-branch').value
    };
    const res = await fetch('/api/cards', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
    });
    if (res.ok) {
        closeModal('card-modal');
        fetchCards();
    } else {
        const err = await res.json();
        alert(err.error || 'Failed to create card');
    }
}

async function logout() {
    await fetch('/api/auth/logout', {method: 'POST'});
    window.location.href = '/login';
}

async function showAuthenticatedUser() {
    const response = await fetch('/api/auth/me');
    if (response.status === 401) {
        window.location.href = '/login';
        return;
    }

    const json = await response.json();
    const heading = document.querySelector('header h1');
    if (json.data?.username) {
        heading.textContent = `⚡ DevKanban — ${json.data.username}`;
    }
}


function openModal(id) {
    document.getElementById(id).classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

showAuthenticatedUser();
fetchCards().then();