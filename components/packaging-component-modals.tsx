"use client"

import type React from "react"

import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog"
import { useTranslation } from "@/lib/i18n"

interface PackagingComponentModalProps {
  isOpen: boolean
  onClose: () => void
  onSubmit: (name: string) => void
  type: "bottle" | "cork" | "capsule" | "cage" | "container"
  language: string
}

export function PackagingComponentModal({ isOpen, onClose, onSubmit, type, language }: PackagingComponentModalProps) {
  const [name, setName] = useState("")
  const { t } = useTranslation(language)

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    if (name.trim()) {
      onSubmit(name.trim())
      setName("")
      onClose()
    }
  }

  const getTitle = () => {
    switch (type) {
      case "bottle":
        return t("label_bottle_new")
      case "cork":
        return t("label_cork_new")
      case "capsule":
        return t("label_capsule_new")
      case "cage":
        return t("label_cage_new")
      case "container":
        return t("label_container_new")
      default:
        return t("new_component")
    }
  }

  const getNameLabel = () => {
    switch (type) {
      case "bottle":
        return t("label_bottle_name")
      case "cork":
        return t("label_cork_name")
      case "capsule":
        return t("label_capsule_name")
      case "cage":
        return t("label_cage_name")
      case "container":
        return t("label_container_name")
      default:
        return t("name")
    }
  }

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-md">
        <DialogHeader>
          <DialogTitle>{getTitle()}</DialogTitle>
        </DialogHeader>
        <form onSubmit={handleSubmit}>
          <div className="space-y-4 py-4">
            <div className="space-y-2">
              <Label htmlFor="component-name">{getNameLabel()}</Label>
              <Input
                id="component-name"
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder={getNameLabel()}
                required
              />
            </div>
          </div>
          <DialogFooter>
            <Button type="button" variant="outline" onClick={onClose}>
              {t("close")}
            </Button>
            <Button type="submit">{t("submit")}</Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  )
}
