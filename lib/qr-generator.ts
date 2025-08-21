// QR Code generation utilities based on the original PHP helper functions

export interface QRCodeData {
  id: string
  wineName: string
  producer: string
  vintage: string
  alcoholContent: string
  description: string
  nutritionInfo: NutritionInfo
  recyclingInfo: RecyclingInfo
  certifications: string[]
  images: string[]
}

export interface NutritionInfo {
  kcal: number
  kj: number
  fat: number
  saturatedFat: number
  carbohydrates: number
  sugars: number
  proteins: number
  salt: number
  ingredients: string[]
  preservatives: string[]
}

export interface RecyclingInfo {
  bottle: { material: string; code: string }
  cork: { material: string; code: string }
  capsule: { material: string; code: string }
  cage: { material: string; code: string }
  container: { material: string; code: string }
}

export async function generateQRCode(data: QRCodeData): Promise<string> {
  try {
    // Simulate the original PHP function that calls digi-card.net
    const payload = {
      id: data.id,
      wineName: data.wineName,
      producer: data.producer,
      vintage: data.vintage,
      alcoholContent: data.alcoholContent,
      description: data.description,
      nutritionInfo: data.nutritionInfo,
      recyclingInfo: data.recyclingInfo,
      certifications: data.certifications,
      images: data.images,
    }

    // In a real implementation, this would call the external API
    // For now, we'll generate a placeholder QR code URL
    const qrData = encodeURIComponent(JSON.stringify(payload))
    return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${qrData}`
  } catch (error) {
    console.error("Error generating QR code:", error)
    throw new Error("Failed to generate QR code")
  }
}

export function validateImageUrl(url: string): Promise<boolean> {
  return new Promise((resolve) => {
    if (!url || !isValidUrl(url)) {
      resolve(false)
      return
    }

    const img = new Image()
    img.crossOrigin = "anonymous"

    img.onload = () => resolve(true)
    img.onerror = () => resolve(false)

    img.src = url
  })
}

function isValidUrl(string: string): boolean {
  try {
    new URL(string)
    return true
  } catch (_) {
    return false
  }
}

export function formatLabelId(id: number, length = 4): string {
  return id.toString().padStart(length, "0")
}

export function generateModuleId(): string {
  // Generate a unique module ID similar to the PHP version
  const timestamp = Date.now().toString()
  const random = Math.random().toString(36).substring(2)
  return btoa(timestamp + random).substring(0, 16)
}
