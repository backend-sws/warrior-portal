import math

width = 800
height = 800
cx, cy = width/2, height/2

# Increased stroke width and opacity for better visibility
svg = [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {width} {height}" fill="none" stroke="rgba(255, 255, 255, 0.4)" stroke-width="2.5">']

def get_hex_points(cx, cy, r, rotation_deg=0):
    points = []
    for i in range(6):
        angle_deg = 60 * i + rotation_deg
        angle_rad = math.pi / 180 * angle_deg
        points.append((cx + r * math.cos(angle_rad), cy + r * math.sin(angle_rad)))
    return points

# Starts slightly larger so it fills the SVG more
r = 390
angle = 0
for i in range(40):
    points = get_hex_points(cx, cy, r, angle)
    pts_str = " ".join([f"{p[0]:.1f},{p[1]:.1f}" for p in points])
    svg.append(f'  <polygon points="{pts_str}" />')
    r = r * 0.92
    angle += 4

svg.append('</svg>')

with open('public/images/hex-spiral.svg', 'w') as f:
    f.write("\n".join(svg))
