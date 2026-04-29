let page = 0;
let loading = false;

async function loadMore() {
  if (loading) return;
  loading = true;
  document.getElementById('loader').style.display = 'flex';

  const response = await fetch(`/api/news.php?page=${page}`);
  const json     = await response.json();

  renderCards(json.data);

  page++;
  loading = false;
  document.getElementById('loader').style.display = 'none';
}

// GET URL NEWS TO OPEN IN NEW TAB
async function openNews(id) {
    try {
        const response = await fetch('/api/news-url.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });

        if (!response.ok) {
            console.error('Failed to fetch news URL:', response.status);
            return;
        }

        const json = await response.json();

        if (json.url) {
            window.open(json.url, '_blank', 'noopener,noreferrer');
        }

    } catch (error) {
        console.error('Error opening news:', error);
    }
}

// INFINITE SCROLL
function renderCards(items) {
    const zone = document.getElementById('infinite-zone');
    const grid  = document.createElement('div');
    grid.className = 'pn-grid';

    items.forEach(item => {
        grid.innerHTML += `
            <div class="pn-card" onclick="openNews(${parseInt(item.news_id)})">
                <img src="${item.url_img}" alt="" class="pn-card-thumb">
                <div class="pn-card-body">
                    <div class="pn-card-city">📍 ${item.city_name}</div>
                    <div class="pn-card-title">${item.news_title}</div>
                    <div class="pn-card-time">${item.date_publish}</div>
                </div>
            </div>`;
    });

    zone.appendChild(grid);
}

const observer = new IntersectionObserver(
  entries => { if (entries[0].isIntersecting) loadMore(); },
  { rootMargin: '200px' }
);

observer.observe(document.getElementById('loader'));