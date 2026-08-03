import math
import random

# Use a fixed seed so it looks good every time
random.seed(42)

width = 1600
height = 800

svg = [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {width} {height}" fill="none">']

num_nodes = 200
nodes = []
for i in range(num_nodes):
    x = random.uniform(-100, width + 100)
    y = random.uniform(-100, height + 100)
    nodes.append((x, y))

# Draw connecting lines with much higher visibility
for i in range(num_nodes):
    for j in range(i+1, num_nodes):
        x1, y1 = nodes[i]
        x2, y2 = nodes[j]
        dist = math.hypot(x2 - x1, y2 - y1)
        if dist < 140:
            opacity = 1.0 - (dist / 140)
            opacity = min(1.0, opacity * 1.5)  # Boost opacity
            svg.append(f'  <line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" stroke="rgba(255,255,255,{opacity:.2f})" stroke-width="2.5" />')

# Draw nodes/stars with much higher visibility
for x, y in nodes:
    r = random.uniform(2.5, 5.0)
    opacity = random.uniform(0.8, 1.0)
    svg.append(f'  <circle cx="{x:.1f}" cy="{y:.1f}" r="{r:.1f}" fill="rgba(255,255,255,{opacity:.2f})" />')
    # Add a glowing effect for some nodes
    if random.random() > 0.7:
        svg.append(f'  <circle cx="{x:.1f}" cy="{y:.1f}" r="{r*3:.1f}" fill="rgba(255,255,255,{opacity*0.4:.2f})" />')

svg.append('</svg>')

with open('public/images/network-pattern.svg', 'w') as f:
    f.write("\n".join(svg))
