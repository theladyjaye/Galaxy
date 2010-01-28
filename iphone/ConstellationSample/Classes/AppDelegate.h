//
//  ConstellationSampleAppDelegate.h
//  ConstellationSample
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ConstellationDelegate.h"
@class GalaxyForums;

@interface AppDelegate : NSObject <UIApplicationDelegate> {
    UIWindow *window;
	UINavigationController * navigation;
}

+ (Constellation * )constellationWithDelegate:(id<ConstellationDelegate>)delegate;

@property (nonatomic, retain) IBOutlet UIWindow *window;
@property (nonatomic, retain) IBOutlet UINavigationController * navigation;



@end

