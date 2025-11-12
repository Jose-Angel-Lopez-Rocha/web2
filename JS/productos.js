const calzado = [
  { nombre: "Tenis Deportivos", precio: 1200, imagen: "https://th.bing.com/th/id/OIP.gcwCCbC66G5mjayWFfo-8AHaHa?w=213&h=213&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3"},
  { nombre: "Botas de Cuero", precio: 2000, imagen: "https://th.bing.com/th/id/OIP.pLVXgSXh0iFjjvGFFjvRfAHaE8?w=273&h=183&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3" },
  { nombre: "Sandalias", precio: 500, imagen: "https://th.bing.com/th/id/OIP.CYj1R5sRx8rtHaBp8ZZ4swHaE8?w=246&h=180&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3" },
  { nombre: "Zapatos Formales", precio: 1500, imagen: "https://th.bing.com/th/id/OIP.Es89gRBFXeZKEwIStDlz_gHaHa?w=211&h=211&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3"},
];

const contenedor = document.getElementById("contenedor-productos");

calzado.forEach(item => {
  const div = document.createElement("div");
  div.classList.add("servicio-card");

  const img = document.createElement("img");
  img.src = item.imagen;
  img.alt = item.nombre;

  const h3 = document.createElement("h3");
  h3.textContent = item.nombre;

  const p = document.createElement("p");
  p.classList.add("precio-tag");
  p.textContent = `Precio: $${item.precio}`;

  div.appendChild(img);
  div.appendChild(h3);
  div.appendChild(p);

  contenedor.appendChild(div);
});
