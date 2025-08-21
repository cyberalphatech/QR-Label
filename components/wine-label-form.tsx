"use client"

import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Upload, QrCode, Save, Eye } from "lucide-react"
import { CertificationSelector } from "./certification-selector"

export function WineLabelForm() {
  const [formData, setFormData] = useState({
    name: "",
    grapeVariety: "",
    vintage: "",
    alcohol: "",
    description: "",
    characteristics: "",
    color: "",
    taste: "",
    pairing: "",
    lot: "",
    bottleSize: "",
    servingTemp: "",
  })

  const [selectedCertifications, setSelectedCertifications] = useState<string[]>([])

  const [nutritionData, setNutritionData] = useState({
    kcal: "",
    kj: "",
    fats: "",
    saturatedFats: "",
    carbs: "",
    sugars: "",
    proteins: "",
    salt: "",
    ingredients: "",
    preservatives: "",
  })

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-3xl font-sans font-bold">Create Wine Label</h2>
          <p className="text-muted-foreground">Generate a professional QR code label for your wine</p>
        </div>
        <div className="flex gap-3">
          <Button variant="outline">
            <Eye className="w-4 h-4 mr-2" />
            Preview
          </Button>
          <Button className="bg-accent hover:bg-accent/90">
            <Save className="w-4 h-4 mr-2" />
            Save Label
          </Button>
        </div>
      </div>

      <Tabs defaultValue="basic" className="space-y-6">
        <TabsList className="grid w-full grid-cols-5">
          <TabsTrigger value="basic">Basic Info</TabsTrigger>
          <TabsTrigger value="images">Images</TabsTrigger>
          <TabsTrigger value="nutrition">Nutrition</TabsTrigger>
          <TabsTrigger value="recycling">Recycling</TabsTrigger>
          <TabsTrigger value="certifications">Certifications</TabsTrigger>
        </TabsList>

        <TabsContent value="basic" className="space-y-6">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <Card>
              <CardHeader>
                <CardTitle>Wine Information</CardTitle>
                <CardDescription>Basic details about your wine</CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="space-y-2">
                  <Label htmlFor="name">Wine Name</Label>
                  <Input
                    id="name"
                    placeholder="e.g., Chianti Classico"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  />
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="grapeVariety">Grape Variety</Label>
                    <Input
                      id="grapeVariety"
                      placeholder="e.g., Sangiovese"
                      value={formData.grapeVariety}
                      onChange={(e) => setFormData({ ...formData, grapeVariety: e.target.value })}
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="vintage">Vintage</Label>
                    <Input
                      id="vintage"
                      placeholder="e.g., 2021"
                      value={formData.vintage}
                      onChange={(e) => setFormData({ ...formData, vintage: e.target.value })}
                    />
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="alcohol">Alcohol %</Label>
                    <Input
                      id="alcohol"
                      placeholder="e.g., 13.5"
                      value={formData.alcohol}
                      onChange={(e) => setFormData({ ...formData, alcohol: e.target.value })}
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="bottleSize">Bottle Size</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select size" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="375ml">375ml</SelectItem>
                        <SelectItem value="750ml">750ml</SelectItem>
                        <SelectItem value="1.5L">1.5L Magnum</SelectItem>
                        <SelectItem value="3L">3L Double Magnum</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="description">Description</Label>
                  <Textarea
                    id="description"
                    placeholder="Describe your wine..."
                    value={formData.description}
                    onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                  />
                </div>
              </CardContent>
            </Card>

            <Card>
              <CardHeader>
                <CardTitle>Tasting Notes</CardTitle>
                <CardDescription>Sensory characteristics of your wine</CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="space-y-2">
                  <Label htmlFor="color">Color</Label>
                  <Input
                    id="color"
                    placeholder="e.g., Ruby red with garnet reflections"
                    value={formData.color}
                    onChange={(e) => setFormData({ ...formData, color: e.target.value })}
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="taste">Scent & Taste</Label>
                  <Textarea
                    id="taste"
                    placeholder="Describe the aroma and flavor profile..."
                    value={formData.taste}
                    onChange={(e) => setFormData({ ...formData, taste: e.target.value })}
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="pairing">Food Pairing</Label>
                  <Textarea
                    id="pairing"
                    placeholder="Recommended food pairings..."
                    value={formData.pairing}
                    onChange={(e) => setFormData({ ...formData, pairing: e.target.value })}
                  />
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="servingTemp">Serving Temperature</Label>
                    <Input
                      id="servingTemp"
                      placeholder="e.g., 16-18°C"
                      value={formData.servingTemp}
                      onChange={(e) => setFormData({ ...formData, servingTemp: e.target.value })}
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="lot">Lot Number</Label>
                    <Input
                      id="lot"
                      placeholder="e.g., L2021-001"
                      value={formData.lot}
                      onChange={(e) => setFormData({ ...formData, lot: e.target.value })}
                    />
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>
        </TabsContent>

        <TabsContent value="images" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle>Wine Images</CardTitle>
              <CardDescription>Upload up to 3 images of your wine (bottle, label, vineyard)</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                {[1, 2, 3].map((index) => (
                  <div key={index} className="space-y-2">
                    <Label>Image {index}</Label>
                    <div className="border-2 border-dashed border-border rounded-lg p-8 text-center hover:border-accent transition-colors cursor-pointer">
                      <Upload className="w-8 h-8 text-muted-foreground mx-auto mb-2" />
                      <p className="text-sm text-muted-foreground">Click to upload</p>
                      <p className="text-xs text-muted-foreground">PNG, JPG, WEBP up to 10MB</p>
                    </div>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="nutrition" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle>Nutritional Information</CardTitle>
              <CardDescription>Add nutritional facts and ingredients</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div className="space-y-2">
                  <Label htmlFor="kcal">kcal/100ml</Label>
                  <Input
                    id="kcal"
                    placeholder="e.g., 85"
                    value={nutritionData.kcal}
                    onChange={(e) => setNutritionData({ ...nutritionData, kcal: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="kj">kJ/100ml</Label>
                  <Input
                    id="kj"
                    placeholder="e.g., 356"
                    value={nutritionData.kj}
                    onChange={(e) => setNutritionData({ ...nutritionData, kj: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="fats">Fats (g)</Label>
                  <Input
                    id="fats"
                    placeholder="e.g., 0"
                    value={nutritionData.fats}
                    onChange={(e) => setNutritionData({ ...nutritionData, fats: e.target.value })}
                  />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="carbs">Carbs (g)</Label>
                  <Input
                    id="carbs"
                    placeholder="e.g., 2.6"
                    value={nutritionData.carbs}
                    onChange={(e) => setNutritionData({ ...nutritionData, carbs: e.target.value })}
                  />
                </div>
              </div>

              <div className="space-y-2">
                <Label htmlFor="ingredients">Ingredients</Label>
                <Textarea
                  id="ingredients"
                  placeholder="List all ingredients..."
                  value={nutritionData.ingredients}
                  onChange={(e) => setNutritionData({ ...nutritionData, ingredients: e.target.value })}
                />
              </div>

              <div className="space-y-2">
                <Label htmlFor="preservatives">Preservatives & Allergens</Label>
                <Textarea
                  id="preservatives"
                  placeholder="Contains sulfites..."
                  value={nutritionData.preservatives}
                  onChange={(e) => setNutritionData({ ...nutritionData, preservatives: e.target.value })}
                />
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="recycling" className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle>Recycling Information</CardTitle>
              <CardDescription>Environmental and recycling details</CardDescription>
            </CardHeader>
            <CardContent className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-4">
                  <div className="space-y-2">
                    <Label>Bottle Material</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select material" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="glass-green">Green Glass</SelectItem>
                        <SelectItem value="glass-clear">Clear Glass</SelectItem>
                        <SelectItem value="glass-brown">Brown Glass</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <Label>Cork Type</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select cork type" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="natural-cork">Natural Cork</SelectItem>
                        <SelectItem value="synthetic-cork">Synthetic Cork</SelectItem>
                        <SelectItem value="screw-cap">Screw Cap</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <Label>Capsule Material</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select capsule" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="tin">Tin</SelectItem>
                        <SelectItem value="plastic">Plastic</SelectItem>
                        <SelectItem value="wax">Wax</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>

                <div className="space-y-4">
                  <div className="space-y-2">
                    <Label>Label Material</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select label material" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="paper">Paper</SelectItem>
                        <SelectItem value="plastic">Plastic</SelectItem>
                        <SelectItem value="biodegradable">Biodegradable</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <Label>Packaging</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select packaging" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="cardboard">Cardboard Box</SelectItem>
                        <SelectItem value="wood">Wooden Box</SelectItem>
                        <SelectItem value="none">No Packaging</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="p-4 bg-muted rounded-lg">
                    <h4 className="font-medium mb-2">Recycling Instructions</h4>
                    <p className="text-sm text-muted-foreground">
                      Bottle: Glass recycling bin
                      <br />
                      Cork: Organic waste
                      <br />
                      Label: Paper recycling
                    </p>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="certifications" className="space-y-6">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <Card>
              <CardHeader>
                <CardTitle>Wine Certifications</CardTitle>
                <CardDescription>Select applicable certifications for your wine</CardDescription>
              </CardHeader>
              <CardContent>
                <CertificationSelector
                  selectedCertifications={selectedCertifications}
                  onCertificationChange={setSelectedCertifications}
                />
              </CardContent>
            </Card>
          </div>

          {/* QR Code Preview */}
          <Card>
            <CardHeader>
              <CardTitle>QR Code Preview</CardTitle>
              <CardDescription>Preview of the generated QR code for your wine label</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="flex items-center justify-center p-8 bg-muted rounded-lg">
                <div className="text-center space-y-4">
                  <div className="w-32 h-32 bg-background border-2 border-dashed border-border rounded-lg flex items-center justify-center mx-auto">
                    <QrCode className="w-16 h-16 text-muted-foreground" />
                  </div>
                  <p className="text-sm text-muted-foreground">QR code will be generated after saving</p>
                  <Button variant="outline">
                    <QrCode className="w-4 h-4 mr-2" />
                    Generate QR Code
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  )
}
