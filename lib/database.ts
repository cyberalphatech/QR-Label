import mysql from "mysql2/promise"

// External database connection configuration
const dbConfig = {
  host: "165.22.102.58",
  user: "backup_db",
  password: "2EAFXWedLe6PtMbn",
  database: "backup_db",
  charset: "utf8",
  collation: "utf8_general_ci",
  connectionLimit: 10,
  acquireTimeout: 60000,
  timeout: 60000,
}

// Create connection pool for better performance
const pool = mysql.createPool(dbConfig)

export async function executeQuery(query: string, params: any[] = []) {
  try {
    const [results] = await pool.execute(query, params)
    return results
  } catch (error) {
    console.error("Database query error:", error)
    throw error
  }
}

export async function getConnection() {
  return await pool.getConnection()
}

export default pool
