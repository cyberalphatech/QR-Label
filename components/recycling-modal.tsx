"use client"

import { useState } from "react"
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { useTranslation } from "@/lib/i18n"
import { PackagingComponentModal } from "./packaging-component-modals"

interface RecyclingModalProps {
  isOpen: boolean
  onClose: () => void
  onSave: (data: RecyclingData) => void
  language: string
  labelId?: string
}

interface RecyclingData {
  bottle: string
  cork: string
  capsule: string
  cage: string
  container: string
}

const recyclingOptions = {
  bottles: [
    { id: "1", name: "Glass Bottle", code: "GL70", description: "Clear glass wine bottle" },
    { id: "2", name: "Green Glass", code: "GL71", description: "Green tinted glass bottle" },
    { id: "3", name: "Antique Glass", code: "GL72", description: "Antique green glass bottle" },
  ],
  corks: [
    { id: "1", name: "Natural Cork", code: "FOR50", description: "Traditional cork stopper" },
    { id: "2", name: "Synthetic Cork", code: "C/PAP81", description: "Synthetic cork material" },
    { id: "3", name: "Screw Cap", code: "ALU41", description: "Aluminum screw cap closure" },
  ],
  capsules: [
    { id: "1", name: "Aluminum Capsule", code: "ALU41", description: "Aluminum foil capsule" },
    { id: "2", name: "Plastic Capsule", code: "C/PAP81", description: "Plastic capsule cover" },
    { id: "3", name: "Tin Capsule", code: "FE40", description: "Tin foil capsule" },
  ],
  cages: [
    { id: "1", name: "Wire Cage", code: "FE40", description: "Metal wire cage for sparkling wines" },
    { id: "2", name: "Plastic Cage", code: "C/PAP81", description: "Plastic cage for sparkling wines" },
  ],
  containers: [
    { id: "1", name: "Cardboard Box", code: "PAP20", description: "Recyclable cardboard packaging" },
    { id: "2", name: "Wooden Crate", code: "FOR50", description: "Wooden wine crate" },
    { id: "3", name: "Plastic Case", code: "C/PAP81", description: "Plastic carrying case" },
  ],
}

export default function RecyclingModal({ isOpen, onClose, onSave, language, labelId }: RecyclingModalProps) {
  const { t } = useTranslation(language)
  const [recyclingData, setRecyclingData] = useState<RecyclingData>({
    bottle: "",
    cork: "",
    capsule: "",
    cage: "",
    container: "",
  })

  const [showComponentModal, setShowComponentModal] = useState<{
    type: "bottle" | "cork" | "capsule" | "cage" | "container" | null
    isOpen: boolean
  }>({ type: null, isOpen: false })

  const handleSave = () => {
    onSave(recyclingData)
    onClose()
  }

  const handleCreateComponent = (type: "bottle" | "cork" | "capsule" | "cage" | "container") => {
    setShowComponentModal({ type, isOpen: true })
  }

  const handleComponentSubmit = (name: string) => {
    // In real app, this would make an API call to create the component
    console.log(`Creating new ${showComponentModal.type}: ${name}`)
    // For demo, we'll just close the modal
    setShowComponentModal({ type: null, isOpen: false })
  }

  const formatOptionText = (item: { name: string; code: string; description: string }) => {
    return `${item.name} | ${item.code} | ${item.description}`
  }

  const renderSelectWithAddButton = (
    type: "bottle" | "cork" | "capsule" | "cage" | "container",
    options: any[],
    value: string,
    onChange: (value: string) => void,
    label: string,
  ) => (
    <div>
      <div className="flex items-center justify-between mb-2">
        <Label htmlFor={type} className="text-base font-medium">
          {label}
        </Label>
        <Button
          type="button"
          variant="outline"
          size="sm"
          onClick={() => handleCreateComponent(type)}
          className="text-xs"
        >
          + Add New
        </Button>
      </div>
      <Select value={value} onValueChange={onChange}>
        <SelectTrigger>
          <SelectValue placeholder={t("dropdown_non_selected_tex")} />
        </SelectTrigger>
        <SelectContent>
          {options.map((option) => (
            <SelectItem key={option.id} value={option.id}>
              <span className="font-mono text-sm">{formatOptionText(option)}</span>
            </SelectItem>
          ))}
        </SelectContent>
      </Select>
    </div>
  )

  return (
    <>
      <Dialog open={isOpen} onOpenChange={onClose}>
        <DialogContent className="max-w-2xl">
          <DialogHeader>
            <DialogTitle>{t("qr_recycling")}</DialogTitle>
          </DialogHeader>

          <div className="space-y-6 py-4">
            {renderSelectWithAddButton(
              "bottle",
              recyclingOptions.bottles,
              recyclingData.bottle,
              (value) => setRecyclingData((prev) => ({ ...prev, bottle: value })),
              t("label_bottle"),
            )}

            {renderSelectWithAddButton(
              "cork",
              recyclingOptions.corks,
              recyclingData.cork,
              (value) => setRecyclingData((prev) => ({ ...prev, cork: value })),
              t("label_cork"),
            )}

            {renderSelectWithAddButton(
              "capsule",
              recyclingOptions.capsules,
              recyclingData.capsule,
              (value) => setRecyclingData((prev) => ({ ...prev, capsule: value })),
              t("label_capsule"),
            )}

            {renderSelectWithAddButton(
              "cage",
              recyclingOptions.cages,
              recyclingData.cage,
              (value) => setRecyclingData((prev) => ({ ...prev, cage: value })),
              t("label_cage"),
            )}

            {renderSelectWithAddButton(
              "container",
              recyclingOptions.containers,
              recyclingData.container,
              (value) => setRecyclingData((prev) => ({ ...prev, container: value })),
              t("label_container"),
            )}
          </div>

          <DialogFooter>
            <Button variant="outline" onClick={onClose}>
              {t("qr_close")}
            </Button>
            <Button onClick={handleSave} className="bg-blue-600 hover:bg-blue-700">
              {t("qr_save")}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <PackagingComponentModal
        isOpen={showComponentModal.isOpen}
        onClose={() => setShowComponentModal({ type: null, isOpen: false })}
        onSubmit={handleComponentSubmit}
        type={showComponentModal.type!}
        language={language}
      />
    </>
  )
}
