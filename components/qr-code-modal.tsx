"use client"

import { useState, useEffect } from "react"
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import { Download, Share2, Copy } from "lucide-react"
import { generateQRCode, type QRCodeData } from "@/lib/utils/qr-helpers"
import { useTranslation, type Language } from "@/lib/i18n"
import { useToast } from "@/hooks/use-toast"

interface QRCodeModalProps {
  isOpen: boolean
  onClose: () => void
  labelData: QRCodeData | null
  language: Language
}

export function QRCodeModal({ isOpen, onClose, labelData, language }: QRCodeModalProps) {
  const [qrCodeUrl, setQrCodeUrl] = useState<string>("")
  const [isLoading, setIsLoading] = useState(false)
  const { t } = useTranslation(language)
  const { toast } = useToast()

  useEffect(() => {
    if (isOpen && labelData) {
      generateQR()
    }
  }, [isOpen, labelData])

  const generateQR = async () => {
    if (!labelData) return

    setIsLoading(true)
    try {
      const url = await generateQRCode(labelData)
      setQrCodeUrl(url)
    } catch (error) {
      toast({
        title: "Error",
        description: "Failed to generate QR code",
        variant: "destructive",
      })
    } finally {
      setIsLoading(false)
    }
  }

  const handleCopyUrl = async () => {
    if (qrCodeUrl) {
      await navigator.clipboard.writeText(qrCodeUrl)
      toast({
        title: "Copied!",
        description: "QR code URL copied to clipboard",
      })
    }
  }

  const handleDownload = () => {
    if (qrCodeUrl) {
      const link = document.createElement("a")
      link.href = qrCodeUrl
      link.download = `qr-code-${labelData?.id || "wine-label"}.png`
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    }
  }

  if (!labelData) return null

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="max-w-md">
        <DialogHeader>
          <DialogTitle className="flex items-center gap-2">
            {t("qr_code")} - {labelData.wineName}
          </DialogTitle>
        </DialogHeader>

        <div className="space-y-4">
          {/* QR Code Display */}
          <div className="flex justify-center p-4 bg-white rounded-lg border">
            {isLoading ? (
              <div className="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
              </div>
            ) : qrCodeUrl ? (
              <img src={qrCodeUrl || "/placeholder.svg"} alt="QR Code" className="w-48 h-48 rounded-lg" />
            ) : (
              <div className="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                No QR Code
              </div>
            )}
          </div>

          {/* Wine Information */}
          <div className="space-y-2">
            <div className="flex justify-between">
              <span className="font-medium">{t("qr_wine_name")}:</span>
              <span>{labelData.wineName}</span>
            </div>
            <div className="flex justify-between">
              <span className="font-medium">{t("qr_vintage")}:</span>
              <span>{labelData.vintage}</span>
            </div>
            <div className="flex justify-between">
              <span className="font-medium">{t("qr_alchool")}:</span>
              <span>{labelData.alcoholContent}%</span>
            </div>
          </div>

          <Separator />

          {/* Certifications */}
          {labelData.certifications.length > 0 && (
            <div className="space-y-2">
              <span className="font-medium">Certifications:</span>
              <div className="flex flex-wrap gap-1">
                {labelData.certifications.map((cert, index) => (
                  <Badge key={index} variant="secondary" className="text-xs">
                    {cert}
                  </Badge>
                ))}
              </div>
            </div>
          )}

          {/* Action Buttons */}
          <div className="flex gap-2 pt-4">
            <Button onClick={handleDownload} className="flex-1" disabled={!qrCodeUrl}>
              <Download className="w-4 h-4 mr-2" />
              Download
            </Button>
            <Button onClick={handleCopyUrl} variant="outline" disabled={!qrCodeUrl}>
              <Copy className="w-4 h-4" />
            </Button>
            <Button variant="outline" disabled={!qrCodeUrl}>
              <Share2 className="w-4 h-4" />
            </Button>
          </div>
        </div>
      </DialogContent>
    </Dialog>
  )
}
