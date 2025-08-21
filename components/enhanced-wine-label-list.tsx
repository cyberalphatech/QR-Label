"use client"

import { useState, useEffect } from "react"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Search, Edit, QrCode, Trash2, Copy, FileText, Recycle, Award, Briefcase, Calendar, Send } from "lucide-react"
import { useTranslation, type Language } from "@/lib/i18n"
import { QRCodeModal } from "./qr-code-modal"
import type { QRCodeData } from "@/lib/utils/qr-helpers"

interface WineLabel {
  id: string
  name: string
  vintage: string
  producer: string
  printingService?: string
  oenologyService?: string
  alcoholContent: string
  lot: string
  dateCreated: string
  datePublished?: string
  published: boolean
  status: "draft" | "published" | "archived"
  image?: string
  description: string
  nutritionInfo: any
  recyclingInfo: any
  certifications: string[]
}

interface EnhancedWineLabelListProps {
  language: Language
  userType?: 1 | 2 | 3 // 1=producer, 2=printing, 3=oenology
}

export function EnhancedWineLabelList({ language, userType = 1 }: EnhancedWineLabelListProps) {
  const [labels, setLabels] = useState<WineLabel[]>([])
  const [searchTerm, setSearchTerm] = useState("")
  const [selectedLabel, setSelectedLabel] = useState<QRCodeData | null>(null)
  const [showQRModal, setShowQRModal] = useState(false)
  const { t } = useTranslation(language)

  // Mock data - in real app this would come from API
  useEffect(() => {
    const mockLabels: WineLabel[] = [
      {
        id: "001",
        name: "Chianti Classico DOCG",
        vintage: "2020",
        producer: "Castello di Brolio",
        printingService: "Tipografia Toscana",
        oenologyService: "Consulenza Enologica Firenze",
        alcoholContent: "13.5",
        lot: "CC2020-001",
        dateCreated: "2024-01-15",
        datePublished: "2024-01-20",
        published: true,
        status: "published",
        image: "/placeholder.svg?height=40&width=40&text=Wine",
        description: "A classic Chianti with notes of cherry and herbs",
        nutritionInfo: {
          kcal: 85,
          kj: 356,
          fat: 0,
          saturatedFat: 0,
          carbohydrates: 2.6,
          sugars: 0.9,
          proteins: 0.1,
          salt: 0.01,
          ingredients: ["Grapes", "Sulfites"],
          preservatives: ["SO2"],
        },
        recyclingInfo: {
          bottle: { material: "Glass", code: "GL70" },
          cork: { material: "Cork", code: "FOR51" },
          capsule: { material: "Aluminum", code: "ALU41" },
          cage: { material: "Steel", code: "FE40" },
          container: { material: "Cardboard", code: "PAP21" },
        },
        certifications: ["DOCG", "Organic", "EU Certified"],
      },
      {
        id: "002",
        name: "Barolo DOCG",
        vintage: "2018",
        producer: "Marchesi di Barolo",
        printingService: "Stampa Piemonte",
        oenologyService: "Enologia Alba",
        alcoholContent: "14.0",
        lot: "BR2018-002",
        dateCreated: "2024-01-10",
        published: false,
        status: "draft",
        image: "/placeholder.svg?height=40&width=40&text=Wine",
        description: "Premium Barolo with complex tannins",
        nutritionInfo: {
          kcal: 88,
          kj: 368,
          fat: 0,
          saturatedFat: 0,
          carbohydrates: 2.8,
          sugars: 1.1,
          proteins: 0.1,
          salt: 0.01,
          ingredients: ["Nebbiolo Grapes", "Sulfites"],
          preservatives: ["SO2"],
        },
        recyclingInfo: {
          bottle: { material: "Glass", code: "GL70" },
          cork: { material: "Cork", code: "FOR51" },
          capsule: { material: "Aluminum", code: "ALU41" },
          cage: { material: "Steel", code: "FE40" },
          container: { material: "Cardboard", code: "PAP21" },
        },
        certifications: ["DOCG", "Traditional"],
      },
    ]
    setLabels(mockLabels)
  }, [])

  const filteredLabels = labels.filter(
    (label) =>
      label.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      label.producer.toLowerCase().includes(searchTerm.toLowerCase()) ||
      label.lot.toLowerCase().includes(searchTerm.toLowerCase()),
  )

  const handleShowQR = (label: WineLabel) => {
    const qrData: QRCodeData = {
      id: label.id,
      wineName: label.name,
      producer: label.producer,
      vintage: label.vintage,
      alcoholContent: label.alcoholContent,
      description: label.description,
      nutritionInfo: label.nutritionInfo,
      recyclingInfo: label.recyclingInfo,
      certifications: label.certifications,
      images: label.image ? [label.image] : [],
    }
    setSelectedLabel(qrData)
    setShowQRModal(true)
  }

  const handleDuplicate = (labelId: string) => {
    const originalLabel = labels.find((l) => l.id === labelId)
    if (originalLabel) {
      const newLabel = {
        ...originalLabel,
        id: `${labelId}-copy`,
        name: `${originalLabel.name} (Copy)`,
        dateCreated: new Date().toISOString().split("T")[0],
        published: false,
        status: "draft" as const,
      }
      setLabels([...labels, newLabel])
    }
  }

  const handlePublish = (labelId: string) => {
    setLabels(
      labels.map((label) =>
        label.id === labelId ? { ...label, published: true, status: "published" as const } : label,
      ),
    )
  }

  const handleDelete = (labelId: string) => {
    if (confirm("Are you sure you want to delete this label?")) {
      setLabels(labels.filter((label) => label.id !== labelId))
    }
  }

  const ActionButton = ({ action, labelId, label }: { action: string; labelId: string; label: WineLabel }) => {
    const buttonProps = {
      size: "sm" as const,
      variant: "ghost" as const,
      className: "h-8 w-8 p-0",
    }

    switch (action) {
      case "edit":
        return (
          <Button {...buttonProps} title={t("qr_action")}>
            <Edit className="h-4 w-4" />
          </Button>
        )
      case "qr":
        return (
          <Button {...buttonProps} onClick={() => handleShowQR(label)} title={t("qr_code")}>
            <QrCode className="h-4 w-4" />
          </Button>
        )
      case "nutrition":
        return (
          <Button {...buttonProps} title="Nutrition Facts">
            <FileText className="h-4 w-4" />
          </Button>
        )
      case "recycling":
        return (
          <Button {...buttonProps} title={t("qr_recycling")}>
            <Recycle className="h-4 w-4" />
          </Button>
        )
      case "certificate":
        return (
          <Button {...buttonProps} title="Certificates">
            <Award className="h-4 w-4" />
          </Button>
        )
      case "business":
        return (
          <Button {...buttonProps} title="Business Type">
            <Briefcase className="h-4 w-4" />
          </Button>
        )
      case "details":
        return (
          <Button {...buttonProps} title="Details">
            <Calendar className="h-4 w-4" />
          </Button>
        )
      case "duplicate":
        return (
          <Button {...buttonProps} onClick={() => handleDuplicate(labelId)} title="Duplicate">
            <Copy className="h-4 w-4" />
          </Button>
        )
      case "publish":
        return (
          <Button {...buttonProps} onClick={() => handlePublish(labelId)} title="Publish">
            <Send className="h-4 w-4" />
          </Button>
        )
      case "delete":
        return (
          <Button {...buttonProps} onClick={() => handleDelete(labelId)} title="Delete" variant="destructive">
            <Trash2 className="h-4 w-4" />
          </Button>
        )
      default:
        return null
    }
  }

  const getActionsForUserType = (label: WineLabel, userType: number) => {
    if (userType === 1) {
      // Producer
      if (label.status === "published") {
        return ["details", "duplicate", "qr"]
      } else {
        return [
          "edit",
          "nutrition",
          "recycling",
          "certificate",
          "business",
          "duplicate",
          "details",
          "qr",
          "delete",
          "publish",
        ]
      }
    } else if (userType === 2) {
      // Printing
      return ["details", "qr"]
    } else if (userType === 3) {
      // Oenology
      if (label.status === "published") {
        return ["details", "qr"]
      } else {
        return ["edit", "nutrition", "recycling", "certificate", "details", "qr"]
      }
    }
    return ["details", "qr"]
  }

  return (
    <Card>
      <CardHeader>
        <div className="flex items-center justify-between">
          <CardTitle>{t("qr_label_list")}</CardTitle>
          <div className="flex items-center gap-2">
            <div className="relative">
              <Search className="absolute left-2 top-2.5 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Search labels..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="pl-8 w-64"
              />
            </div>
          </div>
        </div>
      </CardHeader>
      <CardContent>
        <div className="rounded-md border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>#</TableHead>
                <TableHead>{t("qr_picture")}</TableHead>
                <TableHead>{t("qr_name")}</TableHead>
                <TableHead>Producer</TableHead>
                <TableHead>Printing Service</TableHead>
                <TableHead>Oenology Service</TableHead>
                <TableHead>{t("qr_lot")}</TableHead>
                <TableHead>{t("qr_date_create")}</TableHead>
                <TableHead>Date Published</TableHead>
                <TableHead>{t("qr_status")}</TableHead>
                <TableHead>{t("qr_action")}</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredLabels.map((label, index) => (
                <TableRow key={label.id}>
                  <TableCell className="font-medium">{index + 1}</TableCell>
                  <TableCell>
                    {label.image && (
                      <img
                        src={label.image || "/placeholder.svg"}
                        alt={label.name}
                        className="w-10 h-10 rounded-full object-cover"
                      />
                    )}
                  </TableCell>
                  <TableCell>
                    <div className="font-medium">{label.name}</div>
                  </TableCell>
                  <TableCell>{label.producer}</TableCell>
                  <TableCell>{label.printingService || "-"}</TableCell>
                  <TableCell>{label.oenologyService || "-"}</TableCell>
                  <TableCell>{label.lot}</TableCell>
                  <TableCell>{label.dateCreated}</TableCell>
                  <TableCell>{label.datePublished || "-"}</TableCell>
                  <TableCell>
                    <Badge variant={label.status === "published" ? "default" : "secondary"}>
                      {label.status === "published" ? "Published" : "Draft"}
                    </Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      {getActionsForUserType(label, userType).map((action) => (
                        <ActionButton key={action} action={action} labelId={label.id} label={label} />
                      ))}
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </div>
      </CardContent>

      <QRCodeModal
        isOpen={showQRModal}
        onClose={() => setShowQRModal(false)}
        labelData={selectedLabel}
        language={language}
      />
    </Card>
  )
}
