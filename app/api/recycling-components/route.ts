import { type NextRequest, NextResponse } from "next/server"
import { executeQuery } from "@/lib/database"

export async function GET(request: NextRequest) {
  try {
    const searchParams = request.nextUrl.searchParams
    const type = searchParams.get("type")

    let query = "SELECT * FROM tblqr_labels_recycling"
    const params: any[] = []

    if (type) {
      query += " WHERE type = ?"
      params.push(type)
    }

    query += " ORDER BY name ASC"

    const components = await executeQuery(query, params)

    return NextResponse.json({ components })
  } catch (error) {
    console.error("Error fetching recycling components:", error)
    return NextResponse.json({ error: "Failed to fetch recycling components" }, { status: 500 })
  }
}

export async function POST(request: NextRequest) {
  try {
    const { type, name, material, recycling_code, disposal_instructions } = await request.json()

    await executeQuery(
      `
      INSERT INTO tblqr_labels_recycling (type, name, material, recycling_code, disposal_instructions)
      VALUES (?, ?, ?, ?, ?)
    `,
      [type, name, material, recycling_code, disposal_instructions],
    )

    return NextResponse.json({
      success: true,
      message: "Recycling component created successfully",
    })
  } catch (error) {
    console.error("Error creating recycling component:", error)
    return NextResponse.json({ error: "Failed to create recycling component" }, { status: 500 })
  }
}
