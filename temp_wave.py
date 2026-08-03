import math

width = 1600
height = 800

# Using Tailwind's cyan/sky colors for the stroke
svg = [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {width} {height}" fill="none" stroke="rgba(14, 165, 233, 0.4)" stroke-width="1.5">']

# We'll create horizontal and vertical-like curves for a wireframe look
for i in range(50):
    points = []
    y_offset = (i - 25) * 12
    for x in range(0, width + 20, 20):
        freq = x * 0.003
        # Complex wave function
        y = height / 2 + y_offset + math.sin(freq + i * 0.1) * 200 * math.cos(x * 0.001)
        z = math.cos(freq * 2 + i * 0.05) * 80
        
        px = x
        py = y + z
        points.append(f"{px:.1f},{py:.1f}")
        
    pts_str = " ".join(points)
    svg.append(f'  <polyline points="{pts_str}" />')

svg.append('</svg>')

with open('public/images/wave-pattern.svg', 'w') as f:
    f.write("\n".join(svg))
