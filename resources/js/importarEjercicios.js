import mysql from "mysql2/promise"; 

async function importarEjercicios() {
  const res = await fetch("https://api.api-ninjas.com/v1/exercises", {
    headers: {
      "X-Api-Key": "pk3D0LVeZzBO0uLpyQuCYnGXfpBrdXTFAqAAifNk"
    }
  });

  const ejercicios = await res.json();

  const db = await mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    database: "BeStrong",
    password: ""
  });

  for (const e of ejercicios) {
    await db.execute(
      "INSERT INTO ejercicios (nombre,  musculo, dificultad) VALUES (?, ?, ?)",
      [e.name,  e.muscle, JSON.stringify(e.difficulty)]
    );
  }
  console.log(ejercicios);
}

importarEjercicios();
