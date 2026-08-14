/* ============================================================
   İPEK HARİTA MÜHENDİSLİK — TIN-MESH.JS
   Interactive CAD Triangulated Irregular Network (TIN) Canvas
   Developed by Kuzeyoku Software
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('tinMeshCanvas');
    if (!canvas) return;

    const section = canvas.closest('section') || canvas.parentElement;
    const ctx = canvas.getContext('2d');

    let width = (canvas.width = section.offsetWidth);
    let height = (canvas.height = section.offsetHeight);

    const isDark = canvas.getAttribute('data-theme') === 'dark' || canvas.classList.contains('tin-mesh-dark');
    const pointColor = isDark ? 'rgba(56, 189, 248, 0.8)' : 'rgba(37, 99, 235, 0.55)';
    const lineRgb = isDark ? '56, 189, 248' : '37, 99, 235';
    const mouseRgb = isDark ? '14, 165, 233' : '2, 132, 199';

    const mouse = {
        x: null,
        y: null,
        radius: 200
    };

    section.addEventListener('mousemove', (e) => {
        const rect = section.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    section.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    window.addEventListener('resize', () => {
        width = canvas.width = section.offsetWidth;
        height = canvas.height = section.offsetHeight;
        initPoints();
    });

    class Point {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;
            this.radius = isDark ? 2.8 : 2.5;
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            if (mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius) {
                    const force = (mouse.radius - dist) / mouse.radius;
                    this.x += (dx / dist) * force * 0.6;
                    this.y += (dy / dist) * force * 0.6;
                }
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = pointColor;
            ctx.fill();
        }
    }

    let points = [];

    function initPoints() {
        points = [];
        const count = Math.min(Math.floor((width * height) / 15000), 55);
        for (let i = 0; i < count; i++) {
            points.push(new Point());
        }
    }

    initPoints();

    function animate() {
        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < points.length; i++) {
            points[i].update();
            points[i].draw();
        }

        const maxDist = 140;
        for (let i = 0; i < points.length; i++) {
            for (let j = i + 1; j < points.length; j++) {
                const dx = points[i].x - points[j].x;
                const dy = points[i].y - points[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < maxDist) {
                    const opacity = (1 - dist / maxDist) * (isDark ? 0.35 : 0.25);
                    ctx.beginPath();
                    ctx.moveTo(points[i].x, points[i].y);
                    ctx.lineTo(points[j].x, points[j].y);
                    ctx.strokeStyle = `rgba(${lineRgb}, ${opacity})`;
                    ctx.lineWidth = 0.9;
                    ctx.stroke();

                    for (let k = j + 1; k < points.length; k++) {
                        const dx2 = points[j].x - points[k].x;
                        const dy2 = points[j].y - points[k].y;
                        const dist2 = Math.sqrt(dx2 * dx2 + dy2 * dy2);

                        if (dist2 < maxDist * 0.85) {
                            const triOpacity = (1 - (dist + dist2) / (maxDist * 2)) * (isDark ? 0.07 : 0.04);
                            ctx.beginPath();
                            ctx.moveTo(points[i].x, points[i].y);
                            ctx.lineTo(points[j].x, points[j].y);
                            ctx.lineTo(points[k].x, points[k].y);
                            ctx.closePath();
                            ctx.fillStyle = `rgba(${lineRgb}, ${triOpacity})`;
                            ctx.fill();
                        }
                    }
                }
            }

            if (mouse.x !== null && mouse.y !== null) {
                const mDx = points[i].x - mouse.x;
                const mDy = points[i].y - mouse.y;
                const mDist = Math.sqrt(mDx * mDx + mDy * mDy);

                if (mDist < mouse.radius) {
                    const mOpacity = (1 - mDist / mouse.radius) * (isDark ? 0.6 : 0.45);
                    ctx.beginPath();
                    ctx.moveTo(points[i].x, points[i].y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.strokeStyle = `rgba(${mouseRgb}, ${mOpacity})`;
                    ctx.lineWidth = 1.3;
                    ctx.stroke();
                }
            }
        }

        requestAnimationFrame(animate);
    }

    animate();
});
