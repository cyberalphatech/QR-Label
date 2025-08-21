import { type NextRequest, NextResponse } from "next/server"
import { executeQuery } from "@/lib/database"

export async function GET(request: NextRequest) {
  try {
    const searchParams = request.nextUrl.searchParams
    const page = Number.parseInt(searchParams.get("page") || "1")
    const limit = Number.parseInt(searchParams.get("limit") || "10")
    const offset = (page - 1) * limit

    // Get wine labels with pagination
    const labels = await executeQuery(
      `
      SELECT 
        l.*,
        c.company_name as producer_name,
        c.user_type,
        COUNT(cert.id) as certification_count
      FROM tblqr_labels l
      LEFT JOIN tblqr_labels_client c ON l.ID_producer = c.producer_id
      LEFT JOIN tblqr_labels_cert cert ON l.label_id = cert.label_id
      WHERE l.is_delete = 0
      GROUP BY l.id
      ORDER BY l.date_created DESC
      LIMIT ? OFFSET ?
    `,
      [limit, offset],
    )

    // Get total count
    const [{ total }] = (await executeQuery(`
      SELECT COUNT(*) as total 
      FROM tblqr_labels 
      WHERE is_delete = 0
    `)) as any[]

    return NextResponse.json({
      labels,
      pagination: {
        page,
        limit,
        total,
        pages: Math.ceil(total / limit),
      },
    })
  } catch (error) {
    console.error("Error fetching wine labels:", error)
    return NextResponse.json({ error: "Failed to fetch wine labels" }, { status: 500 })
  }
}

export async function POST(request: NextRequest) {
  try {
    const data = await request.json()

    // Generate unique label ID
    const labelId = `WL-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`

    // Insert wine label
    await executeQuery(
      `
      INSERT INTO tblqr_labels (
        label_id, wine_name, producer_name, vintage, alcohol_content,
        volume, wine_type, region, grape_varieties, tasting_notes,
        serving_temperature, food_pairing, ID_producer, status
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `,
      [
        labelId,
        data.wine_name,
        data.producer_name,
        data.vintage,
        data.alcohol_content,
        data.volume,
        data.wine_type,
        data.region,
        data.grape_varieties,
        data.tasting_notes,
        data.serving_temperature,
        data.food_pairing,
        data.producer_id || 1,
        data.status || "draft",
      ],
    )

    return NextResponse.json({
      success: true,
      label_id: labelId,
      message: "Wine label created successfully",
    })
  } catch (error) {
    console.error("Error creating wine label:", error)
    return NextResponse.json({ error: "Failed to create wine label" }, { status: 500 })
  }
}
